<?php



class Task extends Model
{
    public function get_all_data()
    {
        include '../config/database.php';
        $conn = OpenCon();

        $sql = 'SELECT * FROM TASKS';
        $result = $conn->query($sql);

        return $result;
    }
}