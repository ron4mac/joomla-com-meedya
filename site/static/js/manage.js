// simplify cancelling an event
function _pd (e) {
	if (e.preventDefault) { e.preventDefault(); }
	if (e.stopPropagation) { e.stopPropagation(); }
}

// addEventListener
function _ae (elem, evnt, func, capt=false) {
	elem.addEventListener(evnt, func, capt);
}


var Arrange = (function () {
	var dragSrcEl = null,
		iSlctd = null,
		stop = true,
		ctnr = '',
		meeid = 'meeid',
		items;

	// Private functions
/*
	function contains(list, value) {
		for ( var i = 0; i < list.length; ++i ) {
			if (list[i] === value) return true;
		}
		return false;
	}
*/
	function hasItem (e) {
		var typs = e.dataTransfer.types;
		for (var i = 0; i < typs.length; ++i ) {
			if (typs[i] === meeid) return true;
		}
		return false;
	}

	function handleDragStart (e) {
		this.style.opacity = '0.4';  // this / e.target is the source node.

		dragSrcEl = this;
		e.dataTransfer.effectAllowed = 'copyMove';
	//	e.dataTransfer.setData('text/html', this.innerHTML);
		e.dataTransfer.setData(meeid,this.getAttribute('data-id'));
	//	console.log(this.getElementsByTagName("IMG")[0].src);
		e.dataTransfer.setData('imgsrc',this.getElementsByTagName("IMG")[0].src);
	}

	function handleDragOver (e) {
		if (hasItem(e)) {
			_pd(e);
			e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
			return false;
		}
	}

	function handleDragEnter (e) {
		// this / e.target is the current hover target.
		if (hasItem(e)) {
			_pd(e);
			this.classList.add('over');
			return false;
		}
	}

	function handleDragLeave (e) {
		this.classList.remove('over');  // this / e.target is previous target element.
	}

	function handleDrop (e) {
		// this / e.target is current target element.
		_pd(e);
		// Don't do anything if dropping the same item we're dragging.
		if (/*e.dataTransfer.types.contains(meeid) &&*/ dragSrcEl != this) {
//			console.log(dragSrcEl);
//			console.log(e);
			var area = document.getElementById(ctnr);
			// Set the source item's HTML to the HTML of the item we dropped on.
		//	dragSrcEl.innerHTML = this.innerHTML;
		//	this.innerHTML = e.dataTransfer.getData('text/html');
			var orf = area.removeChild(dragSrcEl);
			area.insertBefore(orf, this);
		}

		return false;
	}

	function handleDragEnd (e) {
		// this/e.target is the source node.
		this.style.opacity = '1.0';

		[].forEach.call(items, function (itm) {
			itm.classList.remove('over');
		});

		itmend.classList.remove('over');

		stop = true;
	}

	function handleDrag (e) {
		stop = true;	//console.log(e);

		if (e.clientY < 50) {
			stop = false;
			scroll(-1);
		}

		if (e.clientY > ($(window).height() - 50)) {
			stop = false;
			scroll(1);
		}
	}

	function tMove (e) {
		if (e.targetTouches.length == 1) {
			var touch = e.targetTouches[0];
			// Place element where the finger is
			this.style.left = touch.pageX + 'px';
			this.style.top = touch.pageY + 'px';
		}
	}

	var scroll = function (step) {
		var scrollY = $(window).scrollTop();
		$(window).scrollTop(scrollY + step);
		if (!stop) {
			setTimeout(function () { scroll(step) }, 60);
		}
	};

	// Return exported functions
	return {
		init: function (iCtnr, iClass) {
			ctnr = iCtnr;
			items = document.querySelectorAll('#'+iCtnr+' .'+iClass);
			[].forEach.call(items, function(itm) {
			//		itm.setAttribute('draggable', 'true');
					_ae(itm, 'drag', handleDrag);
					_ae(itm, 'dragstart', handleDragStart);
					_ae(itm, 'dragenter', handleDragEnter);
					_ae(itm, 'dragover', handleDragOver);
					_ae(itm, 'dragleave', handleDragLeave);
					_ae(itm, 'drop', handleDrop);
					_ae(itm, 'dragend', handleDragEnd);
					_ae(itm, 'touchmove', tMove);
				});
		}
	};
}());


// Need to have a separate Drag and Drop arranger for the gallery album hierarchy
function setAlbPaid (aid, paid, func) {

//	func(''); alert("Actual album move is disabled"); return;

//	var prms = {'aid': aid, 'paid': paid};
	var prms = {'format':'raw','task':'manage.adjustAlbPaid','aid': aid, 'paid': paid};
	prms[formTokn] = 1;
//	$.post(aBaseURL+'manage.adjustAlbPaid', prms, function (d) {
	$.post(myBaseURL, prms, function (d) {
		if (d) {
			console.log(d);
		}
		func(d);
	});
}

var AArrange = (function () {
	var dragSrcEl = null,
		deTarg = null,
		iSlctd = null,
		stop = true,
		ctnr = '',
		meeid = 'meeid',
		items;

	// Private functions

	function hasItem (e) {
		var typs = e.dataTransfer.types;
		for (var i = 0; i < typs.length; ++i ) {
			if (typs[i] === meeid) return true;
		}
		return false;
	}

	function handleDragStart (e) {
		e.target.style.opacity = '0.4';

		dragSrcEl = this;
		e.dataTransfer.effectAllowed = 'copyMove';
	//	e.dataTransfer.setData('text/html', this.innerHTML);
		e.dataTransfer.setData(meeid,this.getAttribute('data-id'));
	//	console.log(this.getElementsByTagName("IMG")[0].src);
//		e.dataTransfer.setData('imgsrc',this.getElementsByTagName("IMG")[0].src);
	}

	function handleDragOver (e) {
		if (hasItem(e)) {
			_pd(e);
			e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
			return false;
		}
	}

	function handleDragEnter (e) {
		// this / e.target is the current hover target.
//		if (hasItem(e)) {
			_pd(e);
			deTarg = e.target;
			this.classList.add('over');
			return false;
//		}
	}

	function handleDragLeave (e) {
//		if (e.target == deTarg) {
			_pd(e);
			this.classList.remove('over');  // this / e.target is previous target element.
//		}
	}

	function handleDrop (e) {
		// this / e.target is current target element.
		_pd(e);
		// Don't do anything if dropping the same item we're dragging.
		if (/*e.dataTransfer.types.contains(meeid) &&*/ dragSrcEl != this) {
//			console.log(dragSrcEl);
//			console.log(e);
		sa = dragSrcEl.getAttribute('data-aid');
		da = e.target.getAttribute('data-aid');
		setAlbPaid(sa, da, function(r){
			if (r) {
				alert("Failed to move album");
			} else {
				e.target.append(dragSrcEl);
			}
		});
//		e.target.append(dragSrcEl);
//			var area = document.getElementById(ctnr);
			// Set the source item's HTML to the HTML of the item we dropped on.
		//	dragSrcEl.innerHTML = this.innerHTML;
		//	this.innerHTML = e.dataTransfer.getData('text/html');
//			var orf = area.removeChild(dragSrcEl);
//			area.insertBefore(orf, this);
		}

		return false;
	}

	function handleDragEnd (e) {
		// this/e.target is the source node.
		this.style.opacity = '1.0';

		[].forEach.call(items, function (itm) {
			itm.classList.remove('over');
		});

		stop = true;
	}

	function handleDrag (e) {
		stop = true;

		if (e.clientY < 50) {
			stop = false;
			scroll(-1);
		}

		if (e.clientY > ($(window).height() - 50)) {
			stop = false;
			scroll(1);
		}
	}

	function tMove (e) {
		if (e.targetTouches.length == 1) {
			var touch = e.targetTouches[0];
			// Place element where the finger is
			this.style.left = touch.pageX + 'px';
			this.style.top = touch.pageY + 'px';
		}
	}

	var scroll = function (step) {
		var scrollY = $(window).scrollTop();
		$(window).scrollTop(scrollY + step);
		if (!stop) {
			setTimeout(function () { scroll(step) }, 500);
		}
	};

	// Return exported functions
	return {
		init: function (iCtnr, iClass) {
			ctnr = iCtnr;
			items = document.querySelectorAll('#'+iCtnr+' .'+iClass);
			[].forEach.call(items, function(itm) {
			//		itm.setAttribute('draggable', 'true');
					_ae(itm, 'drag', handleDrag);
					_ae(itm, 'dragstart', handleDragStart, true);
					_ae(itm, 'dragenter', handleDragEnter);
					_ae(itm, 'dragover', handleDragOver);
					_ae(itm, 'dragleave', handleDragLeave);
					_ae(itm, 'drop', handleDrop);
					_ae(itm, 'dragend', handleDragEnd);
					_ae(itm, 'touchmove', tMove);
				});
		}
	};
}());





function allow_group_select_checkboxes(checkbox_wrapper_id){
	var lastChecked = null;
	var checkboxes = document.querySelectorAll('#'+checkbox_wrapper_id+' input[type="checkbox"]');

	//I'm attaching an index attribute because it's easy, but you could do this other ways
	for (var i=0; i<checkboxes.length; i++) {
		checkboxes[i].setAttribute('data-index', i);
	}

	for (i=0; i<checkboxes.length; i++) {
		checkboxes[i].addEventListener("click",function(e){

			if (lastChecked && e.shiftKey) {
				var i = parseInt(lastChecked.getAttribute('data-index'));
				var j = parseInt(this.getAttribute('data-index'));
				var check_or_uncheck = this.checked;

				var low = i; var high = j;
				if (i > j) {
					low = j; high=i;
				}

				for (var c=0; c<checkboxes.length; c++) {
					if (low <= c && c <=high){
						checkboxes[c].checked = check_or_uncheck;
					}
				}
			}
			lastChecked = this;
		});
	}
}

function handleAlbthmDragOver (e) {
	if (e.dataTransfer.types.indexOf('imgsrc') < 0) return;
	_pd(e);		 // Necessary. Allows us to drop.
	e.dataTransfer.dropEffect = 'copy';  // See the section on the DataTransfer object.
	return false;
}

function handleAlbthmDrop (e)
{
	_pd(e);		// stops the browser from redirecting.
	var src = e.dataTransfer.getData('imgsrc');
	if (src) {
		this.getElementsByTagName("IMG")[0].src = src;
		var atv = document.getElementById('albthmid');
		atv.value = e.dataTransfer.getData('meeid');
	}
	this.style.opacity = '1.0';
}

function hasSelections (sel, alrt=false) {
	if (document.querySelectorAll(sel).length) {
		return true;
	} else {
		if (alrt) alert("Please select some items first.");
		return false;
	}
}

function removeSelected (e) {
	e.preventDefault();
	if (hasSelections("[name='slctimg[]']:checked",true)) {
		document.adminForm.task.value = 'manage.removeItems';
		document.adminForm.submit();
	}
}

function selAllImg (e, X) {
	e.preventDefault();
	var ck = X?'checked':'';
	var xbs = document.adminForm.elements["slctimg[]"];
	// make up for no array returned if there is only one item
	if (!xbs.length) xbs = [xbs];
	for (var i = 0; i < xbs.length; i++) {
		xbs[i].checked = ck;
	}
}

function editSelected (e) {
	e.preventDefault();
	if (hasSelections("input[name='slctimg[]']:checked",true)) {
		document.adminForm.task.value = 'manage.imgsEdit';
		document.adminForm.submit();
	}
}

function addSelected (e) {
	e.preventDefault();
	if (hasSelections("input[name='slctimg[]']:checked",true)) {
		document.adminForm.task.value = 'manage.imgsAddAlbum';
		document.adminForm.submit();
	}
}

var blbI = null;
function blbEscape (e) {
	if (e.keyCode == 27) {
		e.preventDefault();
		blbI.close(function () { document.removeEventListener("keydown", blbEscape); });
	}
}

function lboxPimg (iFile) {
	const src = blb_path + iFile;
	const html = '<img src="' + src + '">';
	blbI = basicLightbox.create(html);
	blbI.show();
	document.addEventListener("keydown", blbEscape);
}
