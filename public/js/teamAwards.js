function hideClass(c){
    var x = document.getElementsByClassName(c);
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = 'none';
    }
}

function showClass(c){
    var x = document.getElementsByClassName(c);
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = 'block';
    }
}

function ta1() {
    showClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
 }
 
 function ta2() {
    hideClass("ta1");
    showClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta3() {
    hideClass("ta1");
    hideClass("ta2");
    showClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta4() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    showClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta5() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    showClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta6() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    showClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta7() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    showClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta8() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    showClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta9() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    showClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta10() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    showClass("ta10");
    hideClass("ta11");
    hideClass("ta12");
  }

  function ta11() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    showClass("ta11");
    hideClass("ta12");
  }

  function ta12() {
    hideClass("ta1");
    hideClass("ta2");
    hideClass("ta3");
    hideClass("ta4");
    hideClass("ta5");
    hideClass("ta6");
    hideClass("ta7");
    hideClass("ta8");
    hideClass("ta9");
    hideClass("ta10");
    hideClass("ta11");
    showClass("ta12");
  }

function changeTable(value){
    n = Number(value)
    img = document.getElementById('awardPhoto')
    switch(n){
        case 1:
            ta1();
            img.src = "/images/trophies/mvp.png";
            break;
        case 2:
            ta2();
            img.src = "/images/trophies/dpoy.png";
            break;
        case 3:
            ta3();
            img.src = "/images/trophies/roy.png";
            break;
        case 4:
            ta4();
            img.src = "/images/trophies/sixthman.png";
            break;
        case 5:
            ta5();
            img.src = "/images/trophies/coach.png";
            break;
        case 6:
            ta6();
            img.src = "/images/trophies/allleague1.png";
            break;
        case 7:
            ta7();
            img.src = "/images/trophies/allleague2.png";
            break;
        case 8:
            ta8();
            img.src = "/images/trophies/allleague3.png";
            break;
        case 9:
            ta9();
            img.src = "/images/trophies/alldefense1.png";
            break;
        case 10:
            ta10();
            img.src = "/images/trophies/alldefense2.png";
            break;
        case 11:
            ta11();
            img.src = "/images/trophies/allrookie1.png";
            break;
        case 12:
            ta12();
            img.src = "/images/trophies/allrookie2.png";
            break;
    }
    lockThead();
}

function lockThead(){

  thead = document.getElementById('thead').style;

  thead.backgroundColor = "white";
  thead.position = "Sticky";
  thead.zIndex = 100;
  thead.top = 0;

}