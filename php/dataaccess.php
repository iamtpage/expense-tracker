<?php
    //Report all errors
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    define("DB_SERVER","localhost");
    define("DB_USER","LOL");
    define("DB_PASSWORD","LOL");
    define("DB_NAME","LOL");
	
    class data 
    {
     
        // database connection object
        private $conn;
        
        function __construct()
        {
            // database connection creation
            $this->conn = new mysqli(DB_SERVER,DB_USER, DB_PASSWORD,DB_NAME) or die($mysqli->error);
        }
		
		function list_expenses()
		{
			//list all expense records
            $query="SELECT name,cost,item_date,category FROM records WHERE 1";
			
			if($stmt = $this->conn->prepare($query))
			{
				$stmt->execute();
				
				$stmt->bind_result($name, $cost, $item_date, $category);

                // Creates an array to store all the matches for keyword query
                $result_array=array();

                // Loop through the obtained rows
                while ($stmt->fetch())
                {
                    // Creates a temp array for the result value ($results)
                    $temp=array($name, $cost, $item_date, $category);
		    
                    // Put this row into the array 'result_array'
                    array_push($result_array,$temp);
                }
		
				//Close connection and return result_array
                $stmt->close();
                return $result_array;
            }

            else
            {
                echo mysqli_error($this->conn);
            }
		}
		
        function add_expense($name, $cost, $date, $category)
        {
            //Insert into the expenses table with format ($name,$cost,$date,$category)
            $query="INSERT INTO  records (name,cost,item_date,category) VALUES('".$name."','".$cost."','".$date."','".$category."')";
            
			// Prepares the SQL query for execution
            if ($stmt = $this->conn->prepare($query))						
            {

                //Execute and Check if success
                if ($stmt->execute())
                {
                    $stmt->close();
					return true;
                }

                //Failed
				else
				{	
					$stmt->close();
					return false;
				}
            }

			//Something went wrong
            else
            {
                echo "Failed connection\n";
                echo mysqli_error($this->conn);
                return false;
            }
        }

        function get_total()
        {
            $query = "SELECT cost FROM records WHERE 1";

            if($stmt = $this->conn->prepare($query))
            {
                $stmt->execute();
                $stmt->bind_result($item);

                // Creates an array to store all the matches for keyword query
                $result_array=array();

                $cost=0;

                // Loop through the obtained rows
                while ($stmt->fetch())
                {
                    // Creates a temp array for the result value ($results)
                    $cost += $item;
                }
        
                //Close connection and return result_array
                $stmt->close();
                return $cost;

            }
        }
		
		function get_graph_data()
		{
			ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
			
			//select all expenses and categories
			$query = "SELECT cost,category FROM records WHERE 1 GROUP BY category";
			
			if($stmt = $this->conn->prepare($query))
			{
				$stmt->execute();
				
				$stmt->bind_result($cost,$category);

                // Creates an array to store all the matches for keyword query
                $result_array=array();

                $prev_cat=" ";
                $prev_sum=0;

                // Loop through the obtained rows
                while ($stmt->fetch())
                {
                    //first element, no prior category
                    if($prev_cat == " ")
                    {
                        $prev_cat = $category;
                        $prev_sum += $cost;
                    }

                    //not first element, found duplicate entry
                    if($category == $prev_cat)
                    {
                        //add cost to running total
                        $prev_sum += $cost;
                    }

                    //new category
                    if($category != $prev_cat)
                    {
                        //push prev_cat and prev_sum to array
                        $temp=array($prev_sum, $prev_cat);
                        array_push($result_array, $temp);

                        //new category, reset
                        $prev_cat = $category;
                        $prev_sum = $cost;

                    }
                }

                //grab last record and push it to array
                $temp=array($prev_sum, $prev_cat);
                array_push($result_array, $temp);
		
				//Close connection and return result_array
                $stmt->close();
                return $result_array;
			}
		}
    }
?>
