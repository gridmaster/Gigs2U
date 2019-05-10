<script>
function toggleFunction() {
  var x = document.getElementById("post_body");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  
  var x = document.getElementById("newsfeedPostOptions");
  if (x.text === "Show Comments") {
    x.text = "Hide Comments";
  } else {
    x.text = "Show Comments";
  }
}
</script>