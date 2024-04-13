<?php 
    $thesis_Title = $_POST['thesis_Title'];
    $author_Name = $_POST['author_Name'];
    $department_Name = $_POST['department_Name'];
    $indicators = $_POST['indicators'];
    $abstract = $_POST['abstract'];
    //Storing Dates in PHP
    $date_Published = $_POST['date_Published'];
    
    //Separating Keywords
    $keywords = $_POST['keywords'];
    $keywordArray = explode(',', $keywords);
    
    //Database Connection Below
    $con = new mysqli('localhost','root','','thesis informatios');
    if($con->connect_error){
        die('Error : ' .$con->connect_error);
    } else {
        // Insert thesis information
        $stmt = $con->prepare("INSERT INTO data(thesis_Title, author_Name, department_Name, date_Published, indicators, abstract) 
        VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $thesis_Title, $author_Name, $department_Name, $date_Published, $indicators, $abstract);
        $stmt->execute();
        $stmt->close();

        // id nung bagong lagay na thesis   
        $thesis_id = $con->insert_id;

        // Insert keywords associated with the thesis
        $stmt = $con->prepare("INSERT INTO keywords(thesis_id, keyword) VALUES(?, ?)");
        $stmt->bind_param("is", $thesis_id, $keyword);

        foreach ($keywordArray as $keyword) {
            // Bind the keyword parameter and execute the statement
            $keyword = trim($keyword); // Trim whitespace from the keyword
            $stmt->execute();
        }
        $stmt->close();

        $con->close();

        echo "Thesis Information Stored... Thank You";
    }   
?>
