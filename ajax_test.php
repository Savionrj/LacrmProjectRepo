<?php

echo"
  <!--front-end file-->
  <script type='text/javascript'>
    function getRandomNumberFromServer() {
      // URL to which the AJAX call will be made
      const url = '/endpoint.php';

      // Data object containing the POST parameters
      let data = new URLSearchParams();
      data.append('min', 1);
      data.append('max', 100);

      // Options for the AJAX call
      const options = {
        method: 'POST',
        body: data,
      };

      // Making the AJAX call
      fetch(url, options)
        .then(response => {
          return response.text(); // Retrieve the plain text response
        })
        .then(data => {
          // Set the response as the innerHTML of a div
          document.getElementById('randomNumber').innerHTML = data;
        })
        .catch(error => {
          // Handle any errors that occurred during the AJAX call
          console.error('Error:', error);
        });


    }
  </script>

  <button onclick='getRandomNumberFromServer()'>Generate random number</button><br /><br />

  <div id='randomNumber'>
    We haven't generated a random number yet
  </div>
";
