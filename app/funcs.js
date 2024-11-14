function tableSearch() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchTable");
  filter = input.value.toUpperCase();
  table = document.getElementById("stockTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[6];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function checkIn() {
  eanVal = document.getElementById("itemCheckin").value;
  console.log(eanVal);
  document.getElementById("hiddenEanval").value = eanVal;
  console.log(document.getElementById("hiddenEanval").value);
  document.getElementById("form1").style.display = 'block';
}