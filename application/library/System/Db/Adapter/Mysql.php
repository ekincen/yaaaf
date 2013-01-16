<?php

class System_Db_Adapter_Mysql
{

    protected $_db;
    protected $_sth;
    protected $_sql;
    protected $_where;
    protected $_tblPrefix;
    protected $_bind=array();

    const TABLE_PREFIX_FLAG = '#@__';

    public function connect($db_host, $db_user, $db_pwd, $db_name, $tbl_prefix)
    {
        $this->_db = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_pwd);
        $this->_db->exec("SET CHARACTER SET utf8");
        $this->_tblPrefix = $tbl_prefix;
        return $this;
    }

    public function select(array $fieldsArr, $calc = '')
    {
        $this->_bind = array();
        $this->_sql = 'SELECT ' . $calc;
        if (isset($fieldsArr[0]))
        { //single table
            $this->_sql .=implode(',', $fieldsArr);
        }
        else
        { //multiple join
            foreach ($fieldsArr as $as => $fields)
            {
                $as.='.';
                $this->_sql .=$as . implode(',' . $as, $fields) . ',';
            }
            $this->_sql = rtrim($this->_sql, ',');
        }
        return $this;
    }

    public function selectCal(array $fieldsArr)
    {
        return $this->select($fieldsArr, ' SQL_CALC_FOUND_ROWS ');
    }

    public function fetchTotal()
    {
        return $this->_db->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
    }

    public function from($table, $as = '')
    {
        $this->_sql.= ' FROM ' . $this->_transTblName($table) . ' ' . $as;
        return $this;
    }

    public function join($table, $as, $on, $type = 'INNER')
    {
        $this->_sql.=' ' . $type . ' JOIN ' . $this->_transTblName($table) . ' ' . $as . ' ON ' . $on;
        return $this;
    }

    public function where($key,$value)
    {
        $this->_where=' WHERE ';
        if(is_array($key)){
            $where=array();
            foreach ($key as $k=>$v) {
                $where[]=$key.'=:'.$key;
                $this->_bind[':'.$k]=$v;
            }
            $this->_where.=implode(' AND ', $where);
        }else{
            $this->_where.=$key.'=:'.$key;   
            $this->_bind = array(':'.$key=>$value);
        }
        $this->_sql.= $this->_where;
        return $this;
    }

    public function orderby($fields)
    {
        $this->_sql.=' ORDER BY ' . $fields;
        return $this;
    }

    public function limit($start, $limit)
    {
        $this->_sql.=' LIMIT ' . $start . ',' . $limit;
        return $this;
    }

    public function pageLimit($current_page = null, $per_pagecount = null){
        //默认显示10条
        $per_pagecount = $per_pagecount > 0 ? $per_pagecount : 10; 
        if (!$current_page)
        {
            if (isset($_GET['page']))
                $current_page = intval($_GET['page']);
        }
        $current_page = $current_page - 1;
        $offset = $current_page >= 0 ? $current_page * $per_pagecount : 0;
        return $this->limit($per_pagecount, $offset);
    }

    public function exec($fetchType = 'fetchAll', $fetch_style = PDO::FETCH_BOTH)
    {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->$fetchType($fetch_style);
    }

    public function query($sql, $fetchType = 'fetchAll', $fetch_style = PDO::FETCH_ASSOC)
    {
        $sth = $this->_db->prepare($this->_transTblName($sql));
        $sth->execute();
        return $sth->$fetchType($fetch_style);
    }

    public function insert($table, array $insert)
    {
        $insert_keys=$insert_values=array();
        foreach ($insert_arr as $k => $v) {
            $insert_keys[]=$k;
            $insert_values[]=':'.$k;
            $this->_bind[':'.$k]=$v;
        }
        $this->_sql = 'INSERT INTO ' . $this->_transTblName($table) . ' (`' . implode('`,`', $insert_keys ). '`) VALUES(' . implode(',', $insert_values ) . ');';
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_db->lastInsertId();
    }

    public function update($table, $set, $cond=array(),$escape=true)
    {
        $set_arr=array();
        if($escape){
            foreach ($set as $k => $v) {
                $set_arr[]=$k.'=:'.$k;
                $this->_bind[':'.$k]=$v;
            }
        }else{
            foreach ($set as $k => $v) {
                $set_arr[]=$k.'='.$v;
            }
        }
        if($cond){
            $this->where($cond);
        }
        $this->_sql = 'UPDATE ' . $this->_transTblName($table) . ' SET '.implode(',', $set_arr).$this->_where;;
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->rowCount();
    }

    public function delete($table, $cond=array())
    {
        if($cond){
            $this->where($cond);
        }
        $this->_sql = 'DELETE FROM ' . $this->_transTblName($table) . $this->_where;
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->rowCount();
    }

    /**
     * 取回结果集中所有字段的值,作为连续数组返回
     * */
    public function fetchNum()
    {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * 取回结果集中所有字段的值,作为关联数组返回
     * */
    public function fetchAll()
    {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 取回所有结果行的第n个字段名值
     * */
    public function fetchCol($index = 0)
    {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetchAll(PDO::FETCH_COLUMN, $index);
    }

    /**
     * 只取回结果集的第一行
     * */
    public function fetchRow($fetch_style = PDO::FETCH_ASSOC)
    {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetch($fetch_style);
    }

    /**
     * 只取回第n个字段值
     * */
    public function fetchOne($index = 0)
    {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetchColumn($index);
    }

    public function beginTransaction()
    {
        $this->_db->beginTransaction();
    }

    public function rollback()
    {
        $this->_db->rollback();
    }

    public function commit()
    {
        $this->_db->commit();
    }

    public function getDb()
    {
        return $this->_db;
    }

    protected function _transTblName($dbName)
    {
        return str_replace(self::TABLE_PREFIX_FLAG, $this->_tblPrefix, $dbName);
    }

}