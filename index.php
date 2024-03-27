<?php
    session_start();
    require_once("db_connection.php");
    require_once("include/header.php");
?>
<!-- fetch all reviews -->
<?php
    $queryReviews="SELECT reviews.id, reviews.content, reviews.created_at, reviews.updated_at,users.first_name,users.last_name FROM reviews INNER JOIN users ON reviews.user_id = users.id ORDER BY reviews.created_at DESC";
    $reviews=fetch_all($queryReviews);

    if(isset($_SESSION['user_id'])){
        $queryUser="SELECT * FROM users WHERE id='{$_SESSION['user_id']}'";
        $user=fetch_record($queryUser);
    }
?>

<nav class="navbar bg-dark text-success">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="#">ReviewsApp</a>
    <div class="d-flex ">  
<?php
if(isset($_SESSION['user_id'])){?>
    <h5 class="me-5 mb-0 ">Welcome <?=$user['first_name']?>!</h5>
    <a href="process.php">Sign out</a>
<?php
}else{?>
    <h5 class="me-5 mb-0 ">Sign in to leave a review</h5>
    <a href="process.php">Sign in</a>
<?php
}
?>    

    </div>
  </div>
</nav>

<div class="container">
    <h1>The Theory of Evolution</h1>
    <p>According to the theory, individuals with traits that enable them to adapt to their environments will help them survive and have more offspring, which will inherit those traits. Individuals with less adaptive traits will less frequently survive to pass them on. Over time, the traits that enable species to survive and reproduce will become more frequent in the population and the population will change, or evolve, according to BioMed Central. Through natural selection, Darwin suggested, genetically diverse species could arise from a common ancestor. </p>
<?php
if(isset($_SESSION['user_id'])){?>
    <h3>Leave a Review</h3>
    <form action="process.php" method="POST" class="form-floating ">
        <textarea class="form-control" name="review" placeholder="Leave a comment here" style="height: 100px"></textarea>
        <div class="d-flex justify-content-end">
            <input type="submit" class="btn btn-primary mt-1" name="add_review" value="Post a review">
        </div>
    </form>
<?php
}else{?>
    <h3><a href="login.php">Sign in</a> to leave a review </h3>
<?php
}
?>
   

    
    

    <div>
<?php
    foreach($reviews as $review){
        $dateReview = date_format(date_create($review['created_at']),'F js Y h:iA');?>
        <h5><?=$review['first_name']."".$review['last_name']?> (<?=$dateReview?>)</h5>
        <p><?=$review['content']?></p>
        
        <div class="ms-5">
<?php
        $queryReplies="SELECT replies.id, replies.created_at,replies.updated_at, users.first_name, users.last_name, replies.content FROM replies INNER JOIN users ON replies.user_id = users.id WHERE review_id = {$review['id']} ";
        $replies=fetch_all($queryReplies);
        foreach($replies as $reply){
            $dateReply = date_format(date_create($reply["created_at"]),"F js Y h:iA");?>
            <h6><?=$reply['first_name']."".$reply['last_name']?>(<?=$dateReply?>)</h6>
            <p><?=$reply['content']?></p>
            <?php
        }
        if(isset($_SESSION['user_id'])){?>
            <form action="process.php" method="POST" class="form-floating">
                <input type="hidden" name="review_id" value="<?=$review['id']?>">
                <textarea class="form-control" name="reply" placeholder="Leave a comment here" style="height: 80px"></textarea>
                <div class="d-flex justify-content-end">
                    <input type="submit" class="btn btn-success mt-1" name="add_reply" value="Reply">
                </div>
            </form>

 <?php            
        }
?>
            


        </div>


<?php        
    }
?>
        
    </div>
</div>

<?php
    
    require_once("include/footer.php");
?>
