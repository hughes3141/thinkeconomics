<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
  <head>
    <?php include "../header.php"; ?>

    <style>

      input {
        width: 40px;
      }
      
      #whole_pop_container {
        color: blue;
      }

      .pop_header {
        margin-left: 5px;
      }
      #population {
        border: 5px solid blue;
        
     
        display: flex;
        flex-wrap: wrap;
        padding-top: 5px;
 
        
      }

      #workforce {
        border: 5px solid red;

      
      }

      #workforce_container {
        color: red;
        //flex: 4 0 50%;
      }

      #employed {
        border: 5px solid greenyellow;
        height: 100px;
        color: greenyellow
      }

      #unemployed {
        border: 5px solid purple;
        color: purple;
        height: 50px;
      }

      #inactive_container {
        color: magenta;
        //flex: 1 0 50%;
      }

      #inactive {
        border: 5px solid magenta;
        height: 160px;
        
 
      }

      

      .labour_category {
        box-sizing:border-box;
        border-radius: 10px;
        
      
      }

      .pop_container {
          flex: 50%;
        //float: left;
        box-sizing:border-box;
      }

      #button_container {
        display: flex;
        flex-wrap: wrap;
        padding: 5px;
      }

      .button_group {
        flex: 30%;
        height: 150px;
     
      }

      button {
        width: 100%;
        height: 50%; 
        display: block;
        margin-left: auto;
        margin-right: auto;
      }

      @media (max-width: 400px) {
        .pop_container {
          flex: 100%;
        }
        .button_group {
          flex: 100%;
        }
      }
      
    </style>
  </head>
  <body onload="calculate()">
    
    <?php include "../navbar.php"; ?>
    <h1>2.2.3 Unemployment Calculator</h1>
    <p>Use the following information to experiment with unemployment figures. See if you can explain how the unemployment rate can change without having an effect on the employment rate.</p>

    <div id="whole_pop_container"><span class="pop_header">Working-Age Population</span>
      <div id="population" class="labour_category">
        <div class="pop_container labour-category" id="workforce_container"><span class="pop_header">Labour Force</span>
          <div id="workforce" class="labour_category">
            <div id="employed" class="labour_category">
              <label for="employed_no">Employed:</label>
              <input id="employed_no" type="number" onchange="calculate()">
            </div>
            <div id="unemployed" class="labour_category">
              <label for="unemployed_no">Unemployed:</label>
              <input id="unemployed_no" type="number" onchange="calculate()">
            </div>
          </div>
        </div>
        <div class="pop_container" id="inactive_container"><span class="pop_header">Economically Inactive</span>
          <div id="inactive" class="labour_category">
            <label for="inactive_no">Economically Inactive:</label>
            <input id="inactive_no" type="number" onchange="calculate()">
          </div>
        </div>
      </div>
    </div>
    <div id="button_container">
      <div class="button_group">
        <button onclick="moveWorker(1, -1, 0)">Move Worker from Unemployed to Employed</button>
        <button onclick="moveWorker(-1, 1, 0)">Move Worker from Employed to Unmployed</button>
      </div>
      <div class="button_group">
        <button onclick="moveWorker(1, 0, -1)">Move Worker from Inactive to Employed</button>
        <button onclick="moveWorker(-1, 0, 1)">Move Worker from Employed to Inactive</button>
      </div>
      <div style class="button_group">
        <button onclick="moveWorker(0, 1, -1)">Move Worker from Inactive to Unemployed</button>
        <button onclick="moveWorker(0,-1, 1)">Move Worker from Unemployed to Inactive</button>
      </div>
    </div>
    
    
    
    
    <div style="display: block;">
      <p>Total Population: <span class="population_no_output"></span></p>
      <p>Total Labour Force: <span class="labour_force_no_output"></span></p>
      <p>Unemployment Rate: <span class="unemployed_no_output"></span> &divide; <span class="labour_force_no_output"></span>  = <span class="unemployment_rate_output"></span> &percnt;
      </p>
      <p>Employment Rate:  <span class="employed_no_output"></span> &divide; <span class="population_no_output"></span> = <span class="employment_rate_output"></span> &percnt;</p>
    </div>

    <?php include "../footer.php"; ?>
    <script>
      var index = [70,5,25];

      index[0] = getRndInteger(65,75);
      index[1] = getRndInteger(3,8);
      index[2] = 100 - index[0] - index[1];

      fillValues(index[0], index[1], index[2]);
      
      var employed;
      var unemployed;
      var inactive;


      //console.log(index);

      function fillValues(i,j,k) {
        var employed = document.getElementById("employed_no");
        var unemployed = document.getElementById("unemployed_no");
        var inactive = document.getElementById("inactive_no");

        employed.value = i;
        unemployed.value = j;
        inactive.value = k;

        var unemploymentRate = j/(i+j);
        return unemploymentRate;

        var employmentRate = i/(i+j+k);
        return employmentRate
      }

      

      function calculate() {

        employed = parseInt(document.getElementById("employed_no").value);
        unemployed = parseInt(document.getElementById("unemployed_no").value);
        inactive = parseInt(document.getElementById("inactive_no").value);

        //console.log(employed, unemployed, inactive);

        

        var unemploymentRate = unemployed/(employed+unemployed);
        //return unemploymentRate;

        var employmentRate = employed/(employed+unemployed+inactive);
        //return employmentRate;

        console.log(unemploymentRate, employmentRate);
        
        fillOutputNumbers();

      }

      function fillOutputNumbers() {
        var population_no_output = document.getElementsByClassName("population_no_output");
        for (var i=0; i<population_no_output.length; i++) {
          population_no_output[i].innerHTML = employed + unemployed + inactive;
        }

        
        
        var unemployment_no_output = document.getElementsByClassName("unemployed_no_output");
        for (var i=0; i<unemployment_no_output.length; i++) {
          unemployment_no_output[i].innerHTML = unemployed;
        }

        var employment_no_output = document.getElementsByClassName("employed_no_output");
        for (var i=0; i<employment_no_output.length; i++) {
          employment_no_output[i].innerHTML = employed;
        }

        var labour_force_no_output = document.getElementsByClassName("labour_force_no_output");
        for (var i=0; i<labour_force_no_output.length; i++) {
          labour_force_no_output[i].innerHTML = employed + unemployed;
        }

        var unemployment_rate_output = document.getElementsByClassName("unemployment_rate_output");
        for (var i=0; i<unemployment_rate_output.length; i++) {
          var rate = unemployed / (employed + unemployed)*100;
          unemployment_rate_output[i].innerHTML = roundTo(rate, 2);
        }
        
        var employment_rate_output = document.getElementsByClassName("employment_rate_output");
        for (var i=0; i<employment_rate_output.length; i++) {
          var rate = employed / (employed + unemployed + inactive)*100;
          employment_rate_output[i].innerHTML = roundTo(rate, 2);
        }
        
      }

      function moveWorker(a,b,c) {
        var employed_input = document.getElementById("employed_no");
        var unemployed_input = document.getElementById("unemployed_no");
        var inactive_input = document.getElementById("inactive_no");

        if (((employed>0)||(a>0))&&((unemployed>0)||(b>0))&&((inactive>0)||(c>0))) {
          employed_input.value = parseInt(employed_input.value) + a;
          unemployed_input.value = parseInt(unemployed_input.value) + b;
          inactive_input.value = parseInt(inactive_input.value) + c;
        }
     
      
        

        calculate();

      }



      function roundTo(num, digit) {
        return Math.round((num + Number.EPSILON) * 10**digit) / 10**digit;
      }

      function getRndInteger(min, max) {
        return Math.floor(Math.random() * (max - min + 1) ) + min;
      }

    </script>
  </body>
</html>