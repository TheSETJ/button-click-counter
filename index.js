function getClicksCount() {
  // request current count
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

  request.open('GET', './api.php?fn=getClicksCount', true);
  request.send();
}

function countClick() {
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

  request.open('POST', './api.php?fn=updateClicksCount', true);
  request.send();
}
