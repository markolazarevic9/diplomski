let errMess = document.querySelector("body > div.wrong-data");
let searchBox = document.querySelector("#pretraga");
let searchBoxMed = document.querySelector("#pretragaLek");

if (errMess) {
  setTimeout(function () {
    errMess.style.display = "none";
  }, 2000);
}

if (searchBox) {
  searchBox.addEventListener("input", () => {
    let search = $("#pretraga").val();
    $.get("ajax/search.php", { search: search }, function (odg) {
      $("tbody").html(odg);
    });
  });
}

if (searchBoxMed) {
  searchBoxMed.addEventListener("input", () => {
    let search = $("#pretragaLek").val().trim();
    console.log(search);
    $.get("ajax/searchMed.php", { search: search }, function (odg) {
      $("tbody").html(odg);
    });
  });
}
