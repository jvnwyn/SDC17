const search = () => {
    const searchbar = document.getElementById("searchbar").value.toUpperCase();
    const items = document.querySelectorAll(".item");
  
    for (let i = 0; i < items.length; i++) {
      let match = items[i].getElementsByTagName("p")[0]; // Corrected to h3 since pname references h3 tags
  
      if (match) {
        let textvalue = match.textContent || match.innerHTML;
  
        if (textvalue.toUpperCase().indexOf(searchbar) > -1) {
          items[i].style.display = "";
        } else {
          items[i].style.display = "none";
        }
      }
    }
};
  