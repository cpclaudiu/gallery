<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()){ redirect("login.php"); } ?>


<?php 

$photo = Photo::find_by_id($_GET['id']);

if(empty($_GET['id'])){

	redirect("../comments.php");

}

$comment = Comment::find_by_id($_GET['id']);

if($comment){

	$comment->delete();
	$session->message("The comment with {$comment->id} has been deleted");
	redirect("comments.php");
	/* redirect("comment_photo.php?id=<?php $photo->id; ?>"); */

} else {

	redirect("comments.php");
}


?>