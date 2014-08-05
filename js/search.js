// JavaScript Document
function showAdvanced(){
	//This hides the basic search form
    var basic = document.getElementsByClassName('basic-search');
    for(var i = 0, length = basic.length; i < length; i++) {
          basic[i].style.display = 'none';
    }
	//This hides the advanced search link
    var advancedLink = document.getElementsByClassName('show-advanced');
    for(var i = 0, length = advancedLink.length; i < length; i++) {
          advancedLink[i].style.display = 'none';
	}
	//This shows the advanced search form
    var advanced = document.getElementsByClassName('advanced-search');
    for(var i = 0, length = advanced.length; i < length; i++) {
          advanced[i].style.display = 'block';
	}
	//This hides the advanced search link
    var basicLink = document.getElementsByClassName('show-basic');
    for(var i = 0, length = basicLink.length; i < length; i++) {
          basicLink[i].style.display = 'block';
	}
}

function showBasic(){
	//This hides the advanced search form
    var advanced = document.getElementsByClassName('advanced-search');
    for(var i = 0, length = advanced.length; i < length; i++) {
          advanced[i].style.display = 'none';
    }
	//This hides the basic search link
    var basicLink = document.getElementsByClassName('show-basic');
    for(var i = 0, length = basicLink.length; i < length; i++) {
          basicLink[i].style.display = 'none';
	}
	//This shows the basic search form
    var basic = document.getElementsByClassName('basic-search');
    for(var i = 0, length = basic.length; i < length; i++) {
          basic[i].style.display = 'block';
	}
	//This hides the advanced search link
    var advancedLink = document.getElementsByClassName('show-advanced');
    for(var i = 0, length = advancedLink.length; i < length; i++) {
          advancedLink[i].style.display = 'block';
	}
}