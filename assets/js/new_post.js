$(document).ready(function() {
    let summernote_div = $('#summernote');
    summernote_div.summernote({
        height: 500
    });
});

document.querySelector("#add_post").addEventListener("click", ()=>{
   let name = document.querySelector("[name='name']").value,
       cover = document.querySelector("[name='cover']").value,
       text = $('#summernote').summernote("code"),
       tags_array = [
           document.querySelector("[name='main_tag']").value
       ],
       tags = document.querySelector("[name='tags']").value.split(",");
   if (tags.length) {
       tags_array = tags_array.concat(tags);
   }
   tags = tags_array.join(",");
    let data = new FormData();
    data.append("name", name);
    data.append("cover", cover);
    data.append("text", text);
    data.append("tags", tags);
   fetch("scripts/add_post.php", {
       method: "POST",
       body: data
   }).then(()=>{
       location.reload();
   });
});