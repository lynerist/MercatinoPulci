function rimuovi(me, other) {
	let m = document.getElementById(me);
	let o = document.getElementById(other);
	let box = document.getElementById(m.id.substring(7));

	m.style.display = "none";
	o.style.display = "block";
	if (box.style.opacity === "0.5"){
		box.style.opacity = "1";
	}else{
		box.style.opacity = "0.5";
		o.style.opacity = "1";
	}
}