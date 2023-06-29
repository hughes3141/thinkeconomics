function changeVisibility(button, id) {

  /*
  This function is used for tables which toggle between view and edit modes.
  How to use:
    -Within the TD have two divs:
      -One with class="hide_id"
      -One with class= "show_id"
    -(Repeat above for however many columns there are)
    e.g.:

        <td>
          <div class ="show_<?=$result['id']?>">
            <?=htmlspecialchars($result['userAdmin'])?>
          </div>
          
          <textarea  class="hide hide_<?=$result['id'];?>" name="userAdmin"><?=$result['userAdmin']?></textarea>
        </td>
        
    -Set CSS so that hide style="display:none;"
    -There is a button with text 'Edit' and id = "button_id"
    -The button onclick is: 
      <div>
        <button type ="button" id = "button_<?=$result['id'];?>" onclick = "changeVisibility(this, <?=$result['id'];?>)"">Edit</button>
      </div>
    
  */
  
  if(button.innerHTML =="Edit") {
    button.innerHTML = "Hide Edit";
    var hiddens = document.getElementsByClassName("hide_"+id);
    for (var i=0; i<hiddens.length; i++) {
      hiddens[i].style.display = "block";
    }

    var shows = document.getElementsByClassName("show_"+id);
    //console.log(shows);
    for (var i=0; i<shows.length; i++) {
      
      shows[i].style.display = "none";
    }
  } else {
    button.innerHTML = "Edit";
    var hiddens = document.getElementsByClassName("hide_"+id);
    for (var i=0; i<hiddens.length; i++) {
      hiddens[i].style.display = "none";
    }

    var shows = document.getElementsByClassName("show_"+id);
    //console.log(shows);
    for (var i=0; i<shows.length; i++) {
      
      shows[i].style.display = "block";
    }
  }


}

function toggleHide(button, toggle_class, original_message, toggle_message, display_type="block") {
  let toggleClass = document.getElementsByClassName(toggle_class);
  //console.log(toggleClass);
  function f() {
    for (var i=0; i<toggleClass.length; i++) {
      
      if((toggleClass[i].style.display=="none")||(toggleClass[i].classList.contains('hidden'))) {
        toggleClass[i].style.display=display_type;
        toggleClass[i].classList.remove('hidden')

      }
      else if (toggleClass[i].style.display!="none") {
        toggleClass[i].style.display="none";
      }
      //console.log(toggleClass[i]);
    }

  }
  if(button.innerHTML ==original_message) {
    button.innerHTML = toggle_message;
    f();
 
  }
  else if(button.innerHTML ==toggle_message) {
    button.innerHTML = original_message;
    f();

  }

}