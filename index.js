function countClick() {
  // get current count
  let count = +document.getElementById('click-counter').innerText;

  // increase
  count = count + 1;

  // update the view
  document.getElementById('click-counter').innerText = count.toString();
}
