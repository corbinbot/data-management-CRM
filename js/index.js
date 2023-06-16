function date() {
	if (document.getElementById("searchselect").value == "exp_date_dc") {
		document.getElementById("search").style.display = "none";
		document.getElementById("date_search").style.display = "flex";
	} else {
		document.getElementById("search").style.display = "block";
		document.getElementById("date_search").style.display = "none";
	}
}
