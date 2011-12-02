//Page init scripts
jQuery(function(){
	initCustomFile();
	clearFormElements();
	initCustomForms();
	initSlider();
	initView();
	initDropDown();
});

function initView(){
	var a = jQuery('a.view[href]');
	var sets = {};
	a.each(function () {
		var r = this.rel;
		if( r ){
			if (!sets[r]) {
				sets[r] = [];
			}
			sets[r].push(this);
		}else{
			new View(jQuery(this));
		}
	});
	for (var i in sets) {
		new View(jQuery(sets[i]));
	}
};

function initDropDown()
{
	var nav = document.getElementById("nav");
	if(nav) {
		var lis = nav.getElementsByTagName("li");
		for (var i=0; i<lis.length; i++) {
			if(lis[i].getElementsByTagName("ul").length > 0) {
				lis[i].className += " drop-dawn"
			}
		}
	}
}

/* initSlider */
function initSlider(){
	jQuery('.carousel').each(function(){
		var set = jQuery(this);
		new SliderNV(set,{
			slider:'.frame > ul',
			btnPrev:'a.link-prev',
			btnNext:'a.link-next',
			effect: false,
			pagerLinks: '.switcher > li',
			generatePagination: '.switcher',
			autoRotation: true,
			switchTime:5000,
			autoHeight: true
		});
	});
};
/* slider module */
(function($){
	SliderNV = function(){
		this.init.apply(this,arguments)
	}
	SliderNV.prototype = {
		init: function(context, options){
			/* default options */
			this.options = jQuery.extend({
				sliderHolder: '>div',
				slider:'>ul',
				slides: '>li',
				pagerLinks:'div.pager a',
				generatePagination: false,
				generatePaginationMarkup: '<li><a href="#">&amp;nbsp;</a></li>',
				btnPrev:'a.btn-prev111',
				btnNext:'a.btn-next111',
				activeClass:'active',
				disabledClass:'disabled',
				circleSlide: true,
				effect: true, // true == slide effect & false == fade effect
				pauseClass:'gallery-paused',
				pauseOnHover:true,
				autoRotation:false,
				switchTime:5000,
				animSpeed:650,
				easing:'swing',
				pagerEvent: 'click',
				butttonEvent:'click',
				beforeInit: function(){},
				afterInit:function(){},
				beforeAnimation: function(){},
				afterAnimation: function(){},
				vertical:false,
				reverse: false,
				step: false,
				startElement: 0,
				autoHeight: false
			},options);
			if(!context) return;
			this.set = context;
			this.elementInit();
			this.eventInit();
			if(typeof this.options.beforeInit === 'function') this.options.beforeInit(this);
			this.startPosition(this.currentElement);
			if(typeof this.options.afterInit === 'function') this.options.afterInit(this);
			this.set.data('sliderNV', this);
		},
		elementInit: function(){
			this.sliderHolder = jQuery(this.options.sliderHolder, this.set);
			this.slider = jQuery(this.options.slider, this.set);
			this.slides = jQuery(this.options.slides, this.slider);
			this.sumHeight = 0;
			this.sumWidth = 0;
			this.slides.each(jQuery.proxy(function(i, elem){
				this.sumHeight += jQuery(elem).outerHeight(true);
				this.sumWidth += jQuery(elem).outerWidth(true);
			},this));
			this.currentElement = parseInt(this.options.startElement);
			this.pagination();
			this.stepCount = this.slides.length;
			this.disableButton();
			this.pagerLinks.removeClass(this.options.activeClass).eq(this.currentElement).addClass(this.options.activeClass);
			this.autoSlide();
		},
		eventInit: function(){
			this.set.find(this.options.btnPrev).live(this.options.butttonEvent, jQuery.proxy(function(){
				this.prev();
				return false;
			}, this));
			this.set.find(this.options.btnNext).live(this.options.butttonEvent, jQuery.proxy(function(){
				this.next();
				return false;
			}, this));
			if(this.options.pauseOnHover){
				this.set.bind('mouseenter', jQuery.proxy(function(){
					this.set.addClass(this.options.pauseClass);
					clearTimeout(this.autoTimer);
				}, this)).bind('mouseleave',jQuery.proxy(function(){
					this.set.removeClass(this.options.pauseClass);
					this.autoSlide();
				}, this));
			};
		},
		pagination: function(){
			if(this.options.generatePagination) {
				this.set.find(this.options.generatePagination).empty()
				this.slides.each(jQuery.proxy(function(){
					var temp = jQuery(this.options.generatePaginationMarkup);
					this.set.find(this.options.generatePagination).append(temp);
				},this));
			};
			this.pagerLinks = jQuery(this.options.pagerLinks, this.set);
			if(this.pagerLinks){
				this.pagerLinks.each(jQuery.proxy(function(idx, elem){
					jQuery(elem).bind(this.options.pagerEvent, jQuery.proxy(function(){
						if(!jQuery(elem).hasClass(this.options.activeClass)){
							this.currentElement = idx;
							this.pagerLinks.removeClass(this.options.activeClass).eq(this.currentElement).addClass(this.options.activeClass);
							this.swichFunction(this.currentElement);
							if(!this.options.circleSlide) this.disableButton();
							this.set.data('sliderNV', this);
						};
						return false;
					},this));
				},this));
			};
		},
		prev: function(){
			if(this.currentElement > 0){
				this.currentElement--;
			}
			else if(this.options.circleSlide) {
				this.currentElement = this.stepCount-1;
			}
			this.pagerLinks.removeClass(this.options.activeClass).eq(this.currentElement).addClass(this.options.activeClass);
			this.swichFunction(this.currentElement);
			if(!this.options.circleSlide) this.disableButton();
			this.set.data('sliderNV', this);
		},
		next: function(){
			if(this.currentElement < this.stepCount-1){
				this.currentElement++;
			}
			else if(this.options.circleSlide) {
				this.currentElement = 0;
			}
			this.pagerLinks.removeClass(this.options.activeClass).eq(this.currentElement).addClass(this.options.activeClass);
			this.swichFunction(this.currentElement);
			if(!this.options.circleSlide) this.disableButton();
			this.set.data('sliderNV', this);
		},
		disableButton: function(){
			this.set.find(this.options.btnPrev).removeClass(this.options.disabledClass);
			this.set.find(this.options.btnNext).removeClass(this.options.disabledClass);
			if(this.currentElement == 0){
				this.set.find(this.options.btnPrev).addClass(this.options.disabledClass);
			}
			else if(this.currentElement == this.stepCount-1){
				this.set.find(this.options.btnNext).addClass(this.options.disabledClass);
			};
		},
		recalcOffsets: function(curr){
			if(this.options.vertical) {
				/* slide vertical */
				if(this.options.step) {
					this.stepHeight = this.slides.eq(curr).outerHeight(true)*parseInt(this.options.step);
					this.stepCount = Math.ceil((this.sumHeight-this.sliderHolder.height())/this.stepHeight)+1;
					this.offset = -this.stepHeight*curr;
				} else {
					this.stepHeight = this.sliderHolder.height();
					this.stepCount = Math.ceil(this.sumHeight/this.stepHeight);
					this.offset = -this.stepHeight*curr;
					if(this.offset < this.stepHeight-this.sumHeight) this.offset = this.stepHeight-this.sumHeight;
				}
			}
			else {
				/* slide horizontal */
				if(this.options.step) {
					this.stepWidth = this.slides.eq(curr).outerWidth(true)*parseInt(this.options.step);
					this.stepCount = Math.ceil((this.sumWidth-this.sliderHolder.width())/this.stepWidth)+1;
					this.offset = -this.stepWidth*curr;
					if(this.offset < this.sliderHolder.width()-this.sumWidth) this.offset = this.sliderHolder.width()-this.sumWidth;
				} else {
					this.stepWidth = this.sliderHolder.width();
					this.stepCount = Math.ceil(this.sumWidth/this.stepWidth);
					this.offset = -this.stepWidth*curr;
					if(this.offset < this.stepWidth-this.sumWidth) this.offset = this.stepWidth-this.sumWidth;
				}
			};
			return this.offset;
		},
		swichFunction: function(curr){
			if(!this.options.effect){
				/* fade effect */
				if(typeof this.options.beforeAnimation ==='function') this.options.beforeAnimation(this);
				this.slides.filter(':visible').fadeOut(this.options.animSpeed);
				this.slides.eq(curr).fadeIn(this.options.animSpeed, jQuery.proxy(function(){
					if(typeof this.options.afterAnimation ==='function') this.options.afterAnimation(this);
					this.autoSlide();
					if(this.options.autoHeight) this.slider.css({ position: 'relative', height: this.slides.eq(this.currentElement).outerHeight(true) });
					this.set.data('sliderNV', this);
				},this));
			}
			else {
				/* slide effect */
				var marginType = {};
				marginType[this.options.vertical ? 'marginTop' : 'marginLeft'] = this.recalcOffsets(curr);
				if(typeof this.options.beforeAnimation ==='function') this.options.beforeAnimation(this);
				this.slider.animate(
					marginType,
					{
						queue: false,
						duration: this.options.animSpeed,
						complete: jQuery.proxy(function(){
							if(typeof this.options.afterAnimation ==='function') this.options.afterAnimation(this);
							this.autoSlide();
							this.set.data('sliderNV', this);
						},this)
					}
				);
			};
			this.set.data('sliderNV', this);
		},
		startPosition: function(curr){
			if(this.options.effect) {
				var marginType = {};
				marginType[this.options.vertical ? 'marginTop' : 'marginLeft'] = this.recalcOffsets(curr);
				this.slider.css(marginType);
			}
			else {
				this.slides.css({ position: 'absolute', top: 0, left: 0 });
				this.slider.css({ position: 'relative' });
				if(this.options.autoHeight) this.slider.css({ position: 'relative', height: this.slides.eq(this.currentElement).outerHeight(true) });
				this.slides.hide().eq(this.currentElement).show();
			}
		},
		autoSlide: function(){
			if(this.options.autoRotation && !this.set.hasClass(this.options.pauseClass)){
				if(this.autoTimer) clearTimeout(this.autoTimer);
				this.autoTimer = setTimeout(jQuery.proxy(function(){
					if(this.options.reverse) {
						this.prev();
					}
					else {
						this.next();
					}
				},this), this.options.switchTime + this.options.animSpeed);
			}
		}
	}
})( jQuery );

// custom upload input
function initCustomFile() {
	var inputs = document.getElementsByTagName('input');
	for (var i= 0; i < inputs.length; i++) {
		if(inputs[i].className.indexOf('file-input-area') != -1) {
			new customFileUpload(inputs[i]);
		}
	}
};
// custom file input module
function customFileUpload(obj, opt) {
	if(obj) {
		this.options = {
			jsActiveClass:'file-input-js-active',
			fakeClass:'file-input-value',
			hoverClass:'hover'
		}
		this.fileInput = obj;
		this.fileInput.custClass = this;
		this.init();
	}
}
customFileUpload.prototype = {
	init: function() {
		this.getElements();
		this.setStyles();
		this.addEvents();
	},
	getElements: function() {
		this.fileInputParent = this.fileInput.parentNode;
		this.fileInputParent.className += ' ' + this.options.jsActiveClass;
		var tmpInputs = this.fileInput.parentNode.getElementsByTagName('input');
		for(var i = 0; i < tmpInputs.length; i++) {
			if(tmpInputs[i].className.indexOf(this.options.fakeClass) != -1) {
				this.fakeInput = tmpInputs[i];
				this.fakeInput.readOnly = true;
				break;
			}
		}
	},
	getFileName: function(){
		return this.fileInput.value.replace(/^[\s\S]*(?:\\|\/)([\s\S^\\\/]*)$/g, "$1");
	},
	setStyles: function() {
		// IE styling fix
		if((/(MSIE)/gi).test(navigator.userAgent)) {
			this.tmpNode = document.createElement('span');
			this.fileInputParent.insertBefore(this.tmpNode,this.fileInput);
			this.fileInputParent.insertBefore(this.fileInput,this.tmpNode);
			this.fileInputParent.removeChild(this.tmpNode);
		}
		this.fileInput.style.opacity = 0;
		this.fileInput.style.filter = 'alpha(opacity=0)';
	},
	addEvents: function() {
		this.fileInput.onchange = this.bind(this.updateTitle,this);
		this.fileInput.onmouseover = this.bind(function(){
			this.fileInputParent.className += ' ' + this.options.hoverClass;
		},this);
		this.fileInput.onmouseout = this.bind(function(){
			this.fileInputParent.className = this.fileInputParent.className.replace(' '+this.options.hoverClass,'');
		},this);
	},
	updateTitle: function() {
		if(this.fakeInput) {
			this.fakeInput.value = this.getFileName();
		}
	},
	bind: function(func, scope) {
		return function() {
			return func.apply(scope, arguments);
		}
	}
};

//Init clear form elements
function clearFormElements(){
	clearFormFields({
		clearInputs: true,
		clearTextareas: true,
		passwordFieldText: true,
		addClassFocus: "focus",
		filterClass: "default"
	});
}
function clearFormFields(o){
	if (o.clearInputs == null) o.clearInputs = true;
	if (o.clearTextareas == null) o.clearTextareas = true;
	if (o.passwordFieldText == null) o.passwordFieldText = false;
	if (o.addClassFocus == null) o.addClassFocus = false;
	if (!o.filterClass) o.filterClass = "default";
	if(o.clearInputs) {
		var inputs = document.getElementsByTagName("input");
		for (var i = 0; i < inputs.length; i++ ) {
			if((inputs[i].type == "text" || inputs[i].type == "password") && inputs[i].className.indexOf(o.filterClass) == -1) {
				inputs[i].valueHtml = inputs[i].value;
				inputs[i].onfocus = function ()	{
					if(this.valueHtml == this.value) this.value = "";
					if(this.fake) {
						inputsSwap(this, this.previousSibling);
						this.previousSibling.focus();
					}
					if(o.addClassFocus && !this.fake) {
						this.className += " " + o.addClassFocus;
						this.parentNode.className += " parent-" + o.addClassFocus;
					}
				}
				inputs[i].onblur = function () {
					if(this.value == "") {
						this.value = this.valueHtml;
						if(o.passwordFieldText && this.type == "password") inputsSwap(this, this.nextSibling);
					}
					if(o.addClassFocus) {
						this.className = this.className.replace(o.addClassFocus, "");
						this.parentNode.className = this.parentNode.className.replace("parent-"+o.addClassFocus, "");
					}
				}
				if(o.passwordFieldText && inputs[i].type == "password") {
					var fakeInput = document.createElement("input");
					fakeInput.type = "text";
					fakeInput.value = inputs[i].value;
					fakeInput.className = inputs[i].className;
					fakeInput.fake = true;
					inputs[i].parentNode.insertBefore(fakeInput, inputs[i].nextSibling);
					inputsSwap(inputs[i], null);
				}
			}
		}
	}
	if(o.clearTextareas) {
		var textareas = document.getElementsByTagName("textarea");
		for(var i=0; i<textareas.length; i++) {
			if(textareas[i].className.indexOf(o.filterClass) == -1) {
				textareas[i].valueHtml = textareas[i].value;
				textareas[i].onfocus = function() {
					if(this.value == this.valueHtml) this.value = "";
					if(o.addClassFocus) {
						this.className += " " + o.addClassFocus;
						this.parentNode.className += " parent-" + o.addClassFocus;
					}
				}
				textareas[i].onblur = function() {
					if(this.value == "") this.value = this.valueHtml;
					if(o.addClassFocus) {
						this.className = this.className.replace(o.addClassFocus, "");
						this.parentNode.className = this.parentNode.className.replace("parent-"+o.addClassFocus, "");
					}
				}
			}
		}
	}
	function inputsSwap(el, el2) {
		if(el) el.style.display = "none";
		if(el2) el2.style.display = "inline";
	}
};



// custom forms script
var maxVisibleOptions = 20;
var all_selects = false;
var active_select = null;
var selectText = "please select";

function initCustomForms() {
	getElements();
	separateElements();
	replaceRadios();
	replaceCheckboxes();
	replaceSelects();

	// hide drop when scrolling or resizing window
	if (window.addEventListener) {
		window.addEventListener("scroll", hideActiveSelectDrop, false);
		window.addEventListener("resize", hideActiveSelectDrop, false);
	}
	else if (window.attachEvent) {
		window.attachEvent("onscroll", hideActiveSelectDrop);
		window.attachEvent("onresize", hideActiveSelectDrop);
	}
}

function refreshCustomForms() {
	// remove prevously created elements
	if(window.inputs) {
		for(var i = 0; i < checkboxes.length; i++) {
			if(checkboxes[i].checked) {checkboxes[i]._ca.className = "checkboxAreaChecked";}
			else {checkboxes[i]._ca.className = "checkboxArea";}
		}
		for(var i = 0; i < radios.length; i++) {
			if(radios[i].checked) {radios[i]._ra.className = "radioAreaChecked";}
			else {radios[i]._ra.className = "radioArea";}
		}
		for(var i = 0; i < selects.length; i++) {
			var newText = document.createElement('div');
			if (selects[i].options[selects[i].selectedIndex].title.indexOf('image') != -1) {
				newText.innerHTML = '<img src="'+selects[i].options[selects[i].selectedIndex].title+'" alt="" />';
				newText.innerHTML += '<span>'+selects[i].options[selects[i].selectedIndex].text+'</span>';
			} else {
				newText.innerHTML = selects[i].options[selects[i].selectedIndex].text;
			}
			document.getElementById("mySelectText"+i).innerHTML = newText.innerHTML;
		}
	}
}

// getting all the required elements
function getElements() {
	// remove prevously created elements
	if(window.inputs) {
		for(var i = 0; i < inputs.length; i++) {
			inputs[i].className = inputs[i].className.replace('outtaHere','');
			if(inputs[i]._ca) inputs[i]._ca.parentNode.removeChild(inputs[i]._ca);
			else if(inputs[i]._ra) inputs[i]._ra.parentNode.removeChild(inputs[i]._ra);
		}
		for(i = 0; i < selects.length; i++) {
			selects[i].replaced = null;
			selects[i].className = selects[i].className.replace('outtaHere','');
			selects[i]._optionsDiv._parent.parentNode.removeChild(selects[i]._optionsDiv._parent);
			selects[i]._optionsDiv.parentNode.removeChild(selects[i]._optionsDiv);
		}
	}

	// reset state
	inputs = new Array();
	selects = new Array();
	labels = new Array();
	radios = new Array();
	radioLabels = new Array();
	checkboxes = new Array();
	checkboxLabels = new Array();
	for (var nf = 0; nf < document.getElementsByTagName("form").length; nf++) {
		if(document.forms[nf].className.indexOf("default") < 0) {
			for(var nfi = 0; nfi < document.forms[nf].getElementsByTagName("input").length; nfi++) {inputs.push(document.forms[nf].getElementsByTagName("input")[nfi]);}
			for(var nfl = 0; nfl < document.forms[nf].getElementsByTagName("label").length; nfl++) {labels.push(document.forms[nf].getElementsByTagName("label")[nfl]);}
			for(var nfs = 0; nfs < document.forms[nf].getElementsByTagName("select").length; nfs++) {selects.push(document.forms[nf].getElementsByTagName("select")[nfs]);}
		}
	}
}

// separating all the elements in their respective arrays
function separateElements() {
	var r = 0; var c = 0; var t = 0; var rl = 0; var cl = 0; var tl = 0; var b = 0;
	for (var q = 0; q < inputs.length; q++) {
		if(inputs[q].type == "radio") {
			radios[r] = inputs[q]; ++r;
			for(var w = 0; w < labels.length; w++) {
				if((inputs[q].id) && labels[w].htmlFor == inputs[q].id)
				{
					radioLabels[rl] = labels[w];
					++rl;
				}
			}
		}
		if(inputs[q].type == "checkbox") {
			checkboxes[c] = inputs[q]; ++c;
			for(var w = 0; w < labels.length; w++) {
				if((inputs[q].id) && (labels[w].htmlFor == inputs[q].id))
				{
					checkboxLabels[cl] = labels[w];
					++cl;
				}
			}
		}
	}
}

//replacing radio buttons
function replaceRadios() {
	for (var q = 0; q < radios.length; q++) {
		radios[q].className += " outtaHere";
		var radioArea = document.createElement("div");
		if(radios[q].checked) {
			radioArea.className = "radioAreaChecked";
		}
		else
		{
			radioArea.className = "radioArea";
		}
		radioArea.id = "myRadio" + q;
		radios[q].parentNode.insertBefore(radioArea, radios[q]);
		radios[q]._ra = radioArea;

		radioArea.onclick = new Function('rechangeRadios('+q+')');
		if (radioLabels[q]) {
			if(radios[q].checked) {
				radioLabels[q].className += "radioAreaCheckedLabel";
			}
			radioLabels[q].onclick = new Function('rechangeRadios('+q+')');
		}
	}
	return true;
}

//checking radios
function checkRadios(who) {
	var what = radios[who]._ra;
	for(var q = 0; q < radios.length; q++) {
		if((radios[q]._ra.className == "radioAreaChecked") && (radios[q]._ra.nextSibling.name == radios[who].name))
		{
			radios[q]._ra.className = "radioArea";
		}
	}
	what.className = "radioAreaChecked";
}

//changing radios
function changeRadios(who) {
	if(radios[who].checked) {
		for(var q = 0; q < radios.length; q++) {
			if(radios[q].name == radios[who].name) {
				radios[q].checked = false;
			} 
			radios[who].checked = true; 
			checkRadios(who);
		}
	}
}

//rechanging radios
function rechangeRadios(who) {
	if(!radios[who].checked) {
		for(var q = 0; q < radios.length; q++) {
			if(radios[q].name == radios[who].name) {
				radios[q].checked = false; 
				if(radioLabels[q]) radioLabels[q].className = radioLabels[q].className.replace("radioAreaCheckedLabel","");
			}
		}
		radios[who].checked = true; 
		if(radioLabels[who] && radioLabels[who].className.indexOf("radioAreaCheckedLabel") < 0) {
			radioLabels[who].className += " radioAreaCheckedLabel";
		}
		checkRadios(who);
		
		if(window.$ && window.$.fn) {
			$(radios[who]).trigger('change');
		}
	}
}

//replacing checkboxes
function replaceCheckboxes() {
	for (var q = 0; q < checkboxes.length; q++) {
		checkboxes[q].className += " outtaHere";
		var checkboxArea = document.createElement("div");
		if(checkboxes[q].checked) {
			checkboxArea.className = "checkboxAreaChecked";
			if(checkboxLabels[q]) {
				checkboxLabels[q].className += " checkboxAreaCheckedLabel"
			}
		}
		else {
			checkboxArea.className = "checkboxArea";
		}
		checkboxArea.id = "myCheckbox" + q;
		checkboxes[q].parentNode.insertBefore(checkboxArea, checkboxes[q]);
		checkboxes[q]._ca = checkboxArea;
		checkboxArea.onclick = new Function('rechangeCheckboxes('+q+')');
		if (checkboxLabels[q]) {
			checkboxLabels[q].onclick = new Function('changeCheckboxes('+q+')');
		}
		checkboxes[q].onkeydown = checkEvent;
	}
	return true;
}

//checking checkboxes
function checkCheckboxes(who, action) {
	var what = checkboxes[who]._ca;
	if(action == true) {
		what.className = "checkboxAreaChecked";
		what.checked = true;
	}
	if(action == false) {
		what.className = "checkboxArea";
		what.checked = false;
	}
	if(checkboxLabels[who]) {
		if(checkboxes[who].checked) {
			if(checkboxLabels[who].className.indexOf("checkboxAreaCheckedLabel") < 0) {
				checkboxLabels[who].className += " checkboxAreaCheckedLabel";
			}
		} else {
			checkboxLabels[who].className = checkboxLabels[who].className.replace("checkboxAreaCheckedLabel", "");
		}
	}
	
}

//changing checkboxes
function changeCheckboxes(who) {
	setTimeout(function(){
		if(checkboxes[who].checked) {
			checkCheckboxes(who, true);
		} else {
			checkCheckboxes(who, false);
		}
	},10);
}

// rechanging checkboxes
function rechangeCheckboxes(who) {
	var tester = false;
	if(checkboxes[who].checked == true) {
		tester = false;
	}
	else {
		tester = true;
	}
	checkboxes[who].checked = tester;
	checkCheckboxes(who, tester);
	if(window.$ && window.$.fn) {
		$(checkboxes[who]).trigger('change');
	}
}

// check event
function checkEvent(e) {
	if (!e) var e = window.event;
	if(e.keyCode == 32) {for (var q = 0; q < checkboxes.length; q++) {if(this == checkboxes[q]) {changeCheckboxes(q);}}} //check if space is pressed
}

// replace selects
function replaceSelects() {
	for(var q = 0; q < selects.length; q++) {
		if (!selects[q].replaced && selects[q].offsetWidth) {
			selects[q]._number = q;
			//create and build div structure
			var selectArea = document.createElement("div");
			var left = document.createElement("span");
			left.className = "left";
			selectArea.appendChild(left);

			var disabled = document.createElement("span");
			disabled.className = "disabled";
			selectArea.appendChild(disabled);

			selects[q]._disabled = disabled;
			var center = document.createElement("span");
			var button = document.createElement("a");
			var text = document.createTextNode(selectText);
			center.id = "mySelectText"+q;

			var stWidth = selects[q].offsetWidth;
			selectArea.style.width = stWidth + "px";
			if (selects[q].parentNode.className.indexOf("type2") != -1){
				button.href = "javascript:showOptions("+q+",true)";
			} else {
				button.href = "javascript:showOptions("+q+",false)";
			}
			button.className = "selectButton";
			selectArea.className = "selectArea";
			selectArea.className += " " + selects[q].className;
			selectArea.id = "sarea"+q;
			center.className = "center";
			center.appendChild(text);
			selectArea.appendChild(center);
			selectArea.appendChild(button);

			//insert select div
			selects[q].parentNode.insertBefore(selectArea, selects[q]);
			//build & place options div

			var optionsDiv = document.createElement("div");
			var optionsList = document.createElement("ul");
			var optionsListHolder = document.createElement("div");
			
			optionsListHolder.className = "select-center";
			optionsListHolder.innerHTML =  "<div class='select-center-right'></div>";
			optionsDiv.innerHTML += "<div class='select-top'><div class='select-top-left'></div><div class='select-top-right'></div></div>";
			
			optionsListHolder.appendChild(optionsList);
			optionsDiv.appendChild(optionsListHolder);
			
			selects[q]._optionsDiv = optionsDiv;
			selects[q]._options = optionsList;

			optionsDiv.style.width = stWidth + "px";
			optionsDiv._parent = selectArea;

			optionsDiv.className = "optionsDivInvisible";
			optionsDiv.id = "optionsDiv"+q;

			if(selects[q].className.length) {
				optionsDiv.className += ' drop-'+selects[q].className;
			}

			populateSelectOptions(selects[q]);
			optionsDiv.innerHTML += "<div class='select-bottom'><div class='select-bottom-left'></div><div class='select-bottom-right'></div></div>";
			document.body.appendChild(optionsDiv);
			selects[q].replaced = true;
			
			// too many options
			if(selects[q].options.length > maxVisibleOptions) {
				optionsDiv.className += ' optionsDivScroll';
			}
			
			//hide the select field
			if(selects[q].className.indexOf('default') != -1) {
				selectArea.style.display = 'none';
			} else {
				selects[q].className += " outtaHere";
			}
		}
	}
	all_selects = true;
}

//collecting select options
function populateSelectOptions(me) {
	me._options.innerHTML = "";
	for(var w = 0; w < me.options.length; w++) {
		var optionHolder = document.createElement('li');
		var optionLink = document.createElement('a');
		var optionTxt;
		if (me.options[w].title.indexOf('image') != -1) {
			optionTxt = document.createElement('img');
			optionSpan = document.createElement('span');
			optionTxt.src = me.options[w].title;
			optionSpan = document.createTextNode(me.options[w].text);
		} else {
			optionTxt = document.createTextNode(me.options[w].text);
		}
		
		// hidden default option
		if(me.options[w].className.indexOf('default') != -1) {
			optionHolder.style.display = 'none'
		}
		
		optionLink.href = "javascript:showOptions("+me._number+"); selectMe('"+me.id+"',"+w+","+me._number+");";
		if (me.options[w].title.indexOf('image') != -1) {
			optionLink.appendChild(optionTxt);
			optionLink.appendChild(optionSpan);
		} else {
			optionLink.appendChild(optionTxt);
		}
		optionHolder.appendChild(optionLink);
		me._options.appendChild(optionHolder);
		//check for pre-selected items
		if(me.options[w].selected) {
			selectMe(me.id,w,me._number,true);
		}
	}
	if (me.disabled) {
		me._disabled.style.display = "block";
	} else {
		me._disabled.style.display = "none";
	}
}

//selecting me
function selectMe(selectFieldId,linkNo,selectNo,quiet) {
	selectField = selects[selectNo];
	for(var k = 0; k < selectField.options.length; k++) {
		if(k==linkNo) {
			selectField.options[k].selected = true;
		}
		else {
			selectField.options[k].selected = false;
		}
	}
	
	//show selected option
	textVar = document.getElementById("mySelectText"+selectNo);
	var newText;
	var optionSpan;
	if (selectField.options[linkNo].title.indexOf('image') != -1) {
		newText = document.createElement('img');
		newText.src = selectField.options[linkNo].title;
		optionSpan = document.createElement('span');
		optionSpan = document.createTextNode(selectField.options[linkNo].text);
	} else {
		newText = document.createTextNode(selectField.options[linkNo].text);
	}
	if (selectField.options[linkNo].title.indexOf('image') != -1) {
		if (textVar.childNodes.length > 1) textVar.removeChild(textVar.childNodes[0]);
		textVar.replaceChild(newText, textVar.childNodes[0]);
		textVar.appendChild(optionSpan);
	} else {
		if (textVar.childNodes.length > 1) textVar.removeChild(textVar.childNodes[0]);
		textVar.replaceChild(newText, textVar.childNodes[0]);
	}
	if (!quiet && all_selects) {
		if(typeof selectField.onchange === 'function') {
			selectField.onchange();
		}
		if(window.$ && window.$.fn) {
			$(selectField).trigger('change');
		}
	}
}

//showing options
function showOptions(g) {
	_elem = document.getElementById("optionsDiv"+g);
	var divArea = document.getElementById("sarea"+g);
	if (active_select && active_select != _elem) {
		active_select.className = active_select.className.replace('optionsDivVisible',' optionsDivInvisible');
		active_select.style.height = "auto";
	}
	if(_elem.className.indexOf("optionsDivInvisible") != -1) {
		_elem.style.left = "-9999px";
		_elem.style.top = findPosY(divArea) + divArea.offsetHeight + 'px';
		_elem.className = _elem.className.replace('optionsDivInvisible','');
		_elem.className += " optionsDivVisible";
		/*if (_elem.offsetHeight > 200)
		{
			_elem.style.height = "200px";
		}*/
		_elem.style.left = findPosX(divArea) + 'px';
		
		active_select = _elem;
		if(_elem._parent.className.indexOf('selectAreaActive') < 0) {
			_elem._parent.className += ' selectAreaActive';
		}
		
		if(document.documentElement) {
			document.documentElement.onclick = hideSelectOptions;
		} else {
			window.onclick = hideSelectOptions;
		}
	}
	else if(_elem.className.indexOf("optionsDivVisible") != -1) {
		hideActiveSelectDrop();
	}
	
	// for mouseout
	/*_elem.timer = false;
	_elem.onmouseover = function() {
		if (this.timer) clearTimeout(this.timer);
	}
	_elem.onmouseout = function() {
		var _this = this;
		this.timer = setTimeout(function(){
			_this.style.height = "auto";
			_this.className = _this.className.replace('optionsDivVisible','');
			if (_elem.className.indexOf('optionsDivInvisible') == -1)
				_this.className += " optionsDivInvisible";
		},200);
	}*/
}

function hideActiveSelectDrop() {
	if(active_select) {
		active_select.style.height = "auto";
		active_select.className = active_select.className.replace('optionsDivVisible', '');
		active_select.className = active_select.className.replace('optionsDivInvisible', '');
		active_select._parent.className = active_select._parent.className.replace('selectAreaActive','')
		active_select.className += " optionsDivInvisible";
		active_select = false;
	}
}

function hideSelectOptions(e) {
	if(active_select) {
		if(!e) e = window.event;
		var _target = (e.target || e.srcElement);
		if(!isElementBefore(_target,'selectArea') && !isElementBefore(_target,'optionsDiv')) {
			hideActiveSelectDrop();
			if(document.documentElement) {
				document.documentElement.onclick = function(){};
			}
			else {
				window.onclick = null;
			}
		}
	}
}

function isElementBefore(_el,_class) {
	var _parent = _el;
	do {
		_parent = _parent.parentNode;
	}
	while(_parent && _parent.className != null && _parent.className.indexOf(_class) == -1)
	return _parent.className && _parent.className.indexOf(_class) != -1;
}

function findPosY(obj) {
	if (obj.getBoundingClientRect) {
		var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
		var clientTop = document.documentElement.clientTop || document.body.clientTop || 0;
		return Math.round(obj.getBoundingClientRect().top + scrollTop - clientTop);
	} else {
		var posTop = 0;
		while (obj.offsetParent) {posTop += obj.offsetTop; obj = obj.offsetParent;}
		return posTop;
	}
}

function findPosX(obj) {
	if (obj.getBoundingClientRect) {
		var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft;
		var clientLeft = document.documentElement.clientLeft || document.body.clientLeft || 0;
		return Math.round(obj.getBoundingClientRect().left + scrollLeft - clientLeft);
	} else {
		var posLeft = 0;
		while (obj.offsetParent) {posLeft += obj.offsetLeft; obj = obj.offsetParent;}
		return posLeft;
	}
};

/*
 @name			 View.js ÑÊA simple, lightweight, jQuery photo viewer for the web
 @category   Lightbox, Image Viewer
 @author     Rogie King <rogie@finegoodsmarket.com>
 @copyright  2011-2011 Rogie King
 @license    By purchasing View.js, you agree to the following: View.js remain property of Rogie King. View.js may be used by the licensee in any personal or commercial projects. View.js may not be resold or  redistributed. For example: packaged in an application where it could be downloaded for free, such as an open-source project or other application where View.js is bundled along with other files.
*/

function View(items, opts) {
	
	var $v, $imgs, $list, $cur, 
		$ = jQuery,
		imgs = [], 
		self = this, 
		$bod = $('body');
	
	$v = $('<div class="viewer"><ul></ul><a href="#" class="close" title="Close this viewer">&times;</a></div>').hide();
	$list = $v.find('ul');
	var opts = {
		css: {
			'.viewer *, .viewer': {
				margin: 0,
				padding: 0,
				border: 0
			},
			'.viewer': {
				'background-color': '#222',
				filter: 'progid:DXImageTransform.Microsoft.gradient(startColorstr=#D8000000,endColorstr=#D8000000)',
				'background-color': 'rgba(0,0,0,0.85)',
				position: 'fixed',
				right: 0,
				top: 0,
				left: 0,
				bottom: 0,
				display: 'block',
				overflow: 'hidden',
				'z-index': Math.ceil(new Date().getTime() / 10000000),
				height: '100%',
				width: '100%'
			},
			'.viewer li.current + .loading': {
				'background-position': '0 center'
			},
			'.viewer ul': {
				display: 'block',
				height: '100%',
				width: '100%',
				'white-space': 'nowrap'
			},
			'.viewer li': {
				height: '100%',
				width: '0%',
				overflow: 'hidden',
				display: 'block',
				'float': 'left',
				'text-align': 'center',
				position: 'relative'
			},
			'.viewer li.previous, .viewer li.next': {
				cursor: 'pointer'
			},
			'.viewer li>div': {
				left: '10px',
				right: '10px',
				bottom: '10px',
				top: '10px',
				display: 'block',
				'text-align': 'center',
				position: 'absolute'
			},
			'.viewer li.has-caption>div': {
				bottom: '5em'
			},
			'.viewer li.loading>div': {
				background: 'url(data:image/gif;base64,R0lGODlhDAAMAPIGAFxcXE5OTlZWVkpKSkZGRkJCQgAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFHgAGACwAAAAADAAMAAADLmhaIRJFSQHEGFRMQKQhlVFwngIyWqk8lqpgrYs1rvGMXXnapASmPAsm5EHdJAkAIfkEBR4AAQAsBgABAAMABQAAAgaEbwISHAUAIfkEBR4AAQAsBgADAAUAAwAAAgOEj1kAIfkEBR4AAgAsBgAGAAUAAwAAAgYMDmInegUAIfkEBR4AAQAsBgAGAAMABQAAAgOEj1kAIfkEBR4AAgAsAwAGAAMABQAAAgaUchDAzQUAIfkEBR4AAQAsAQAGAAUAAwAAAgOEj1kAIfkEBR4AAgAsAQADAAUAAwAAAgYEImKnGwUAIfkEBR4AAQAsAwABAAMABQAAAgOEj1kAOw%3D%3D) center center no-repeat'
			},
			'.viewer li.loading.next>div': {
				'background-position': '0 center'
			},
			'.viewer li.loading.previous>div': {
				'background-position': 'right center'
			},
			'.viewer .close': {
				color: '#fff',
				'text-decoration': 'none',
				'font-weight': 'bold',
				'font-size': '20px',
				position: 'absolute',
				right: '15px',
				top: '15px',
				cursor: 'pointer',
				display: 'block',
				opacity: 0.6
			},
			'.viewer .close:hover': {
				opacity: 1
			},
			'.viewer img': {
				'max-width': '100%',
				'max-height': '100%',
				cursor: 'pointer',
				position: 'relative',
				height: 'auto',
				width: 'auto',
				'vertical-align': 'middle',
				'-ms-interpolation-mode': 'bicubic'
			},
			'.viewer .caption': {
				'color': '#aaa',
				'text-shadow': '0 1px 2px rgba(0,0,0,0.8)',
				'line-height': '5em',
				'position': 'absolute',
				'bottom': '0',
				'left': '0',
				'right': '0',
				'visibility': 'hidden'
			},
			'.viewer li.current .caption': {
				'visibility': 'visible'
			},
			'.viewer li.previous': {
				width: '10%'
			},
			'.viewer li.current': {
				width: '80%'
			},
			'.viewer li.first.current': {
				'margin-left': '10%'
			},
			'.viewer li.last.current': {
				'margin-right': '10%'
			},
			'.viewer li.next': {
				width: '10%'
			},
			'.viewer li.previous>div': {
				left: '-50%',
				right: '50%'
			},
			'.viewer li.next>div': {
				right: '-50%',
				left: '50%'
			}
		},
		keys: {
			close: [27],
			prev: [37, 188],
			next: [39, 190]
		},
		loadAhead: 2
	};
	this.next = function () {
		this.show($cur.next().find('img'));
	};
	this.prev = function () {
		this.show($cur.prev().find('img'));
	};
	this.close = function () {
		$v.hide();
		$(document).unbind('keyup.view');
		$bod.css({
			'overflow': $bod.data('viewer-overflow')
		});
	};
	this.open = function () {
		$v.show();
		$(document).bind('keyup.view', key);
		$bod.data('viewer-overflow', $bod.css('overflow')).css({
			'overflow': 'hidden'
		});
		this.sync();
	};
	this.show = function ($img) {
		if (typeof $img == 'string') {
			$img = getImgForUrl($img);
		}
		if ($img.constructor == $ && $img.length > 0) {
			$v.find('li').removeClass('current next previous').removeAttr('title');
			$cur = $parent = $img.parents('li').addClass('current');
			$cur.next().addClass('next').attr('title', 'Next');
			$cur.prev().addClass('previous').attr('title', 'Previous');
			this.sync();
			lazyLoad($cur, opts.loadAhead);
		}
	};
	this.sync = function () {
		var containerHeight = $list.find('li.current>div').height();
		var lineHeight = containerHeight + 'px';
		
		$list.find('li>div>span').each(

		function () {
			$(this).css({
				'line-height': lineHeight
			});
		});
		if (self._ie7) {
			$imgs.css({
				'max-height': lineHeight
			});
			$imgs.each(

			function () {
				var $i = $(this);
				$i.css({
					top: ((containerHeight - $i.height()) / 2 + 'px')
				});
			});
		}
	};
	this.next = function () {
		self.show($cur.next().find('img'));
	};
	this.prev = function () {
		self.show($cur.prev().find('img'));
	};

	function getImgForUrl(src) {
		var search = '[src="' + src + '"],[data-src="' + src + '"]';
		return $i = $imgs.find(search).add(
		$imgs.filter(search)).eq(0);
	};

	function key(e) {
		$.each(
		opts.keys, function (cmd, keys) {
			for (var k = 0; k < keys.length; ++k) {
				if (e.keyCode == keys[k]) {
					self[cmd]();
				}
			}
		});
	};

	function click(e) {
		$t = $(e.target);
		if ($t.is('img')) {
			if ($t.parents('li').is('.current')) {
				self.next();
			} else {
				self.show($t);
			}
		} else if ($t.is('li>div,li')) {
			if ($t.parents('li').is('.next') || $t.is('.next')) {
				self.next();
			} else if ($t.parents('li').is('.previous') || $t.is('.previous')) {
				self.prev();
			} else {
				self.close();
			}
		} else {
			self.close();
		}
	};

	function cssify() {
		
		var $s = $('<style />');
		$('head').prepend($s);
		var s = document.styleSheets[0];
		for (sel in opts.css) {
			var decs = '';
			for (name in opts.css[sel]) {
				decs += name + ':' + opts.css[sel][name] + ';';
			}
			var selectors = sel.split(",");
			for (var i = 0, sel; sel = selectors[i]; ++i) {
				if (s.insertRule) {
					s.insertRule((sel + '{' + decs + '}'), s.cssRules.length);
				} else {
					s.addRule(sel, decs);
				}
			}
		}
	};

	function lazyLoad($pos, loadAhead) {
		load($pos.find('img'));
		$pos.nextAll().slice(0, loadAhead).add($pos.prevAll().slice(0, loadAhead)).find('img').each(

		function (i, img) {
			load(img);
		});
	};

	function load(img) {
		if (!img.src) {
			$(img).attr('src', $(img).attr('data-src'));
		}
	};

	function build() {
		if ($.isArray(imgs)) {
			for (var i = 0, img; img = imgs[i]; ++i) {
				var s = null;
				var $li = $('<li class="loading"/>');
				if (typeof img == 'object' && img.src) {
					s = img.src;
				} else if (typeof img == 'string') {
					s = img;
				}
				var image = new Image();
				image.onload = function () {
					self.sync();
					$(this).css({
						visibility: 'visible'
					}).parents('li').removeClass('loading');
				};
				$(image).css({
					visibility: 'hidden'
				});
				$(image).attr('data-src', s);
				if (img.caption) {
					$li.addClass('has-caption').append(
					$('<span class="caption" />').text(img.caption));
				}
				if (i == 0) {
					$li.addClass('first');
				}
				if (i == (imgs.length - 1)) {
					$li.addClass('last');
				}
				$list.append(
				$li.append(
				$('<div/>').append(
				$('<span/>').append(
				image))));
			}
		}
	};

	function imageLinkClick(e) {
		e.preventDefault();
		self.show(this.href);
		self.open();
	};

	function isImageUrl(url) {
		return /\.(jpeg|jpg|gif|png)$/.test(url);
	};

	function process() {
		if (items.constructor == $) {
			items.find('a[href]').add(items.filter('a[href]')).each(

			function () {
				if (isImageUrl(this.href)) {
					imgs.push({
						src: this.href,
						caption: this.title
					});
				}
				$(this).unbind('click.view').bind('click.view', imageLinkClick);
			});
		} else if ($.isArray(items)) {
			imgs = items;
		}
	};

	function bind() {
		$v.unbind('click.view').bind('click.view', click);
	};

	function init() {
		process();
		build();
		$imgs = $v.find('img');
		$('body').append($v);
		if (!View._cssified) {
			cssify();
		}
		View._cssified = true;
		bind();
		self.sync();
		self.close();
		self.show($imgs.eq(0));
		self._ie7 = navigator.userAgent.indexOf('MSIE 7') > -1;
		$(window).resize(function () {
			self.sync();
		});
	};
	init();
};

View._version = '1.0';

(function () {
	
	var $ = jQuery, s = document.getElementsByTagName('script');
	if (s[s.length - 1].src.indexOf('?auto') > -1) {
		$().ready(function () {
			var $a = $('a.view[href]');
			var sets = {};
			$a.each(function () {
				var r = this.rel;
				if( r ){
					if (!sets[r]) {
						sets[r] = [];
					}
					sets[r].push(this);
				}else{
					new View($(this));
				}
			});
			for (var i in sets) {
				new View($(sets[i]));
			}
		});
	};
})();