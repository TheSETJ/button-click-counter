function countClick() {
  // get current count
  let count = +document.getElementById('click-counter').innerText;

  // request increase
  let request = new XMLHttpRequest();

  request.onreadystatechange = function (event) {
    let target = event.target;

    if (target.readyState === 4) {
      if (target.status === 200) {
        // update the view
        document.getElementById('click-counter').innerText = target.responseText;
      }

      console.log({status: target.status, response: target.responseText});
    }
  }

  request.open('POST', './api.php', true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send('fn=updateClicksCount&count=' + count);
}
