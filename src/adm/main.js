(function() {

	'use strict';


	const API = {
		list: '/webdav/adm/api/list/',
		add: '/webdav/adm/api/add/'
	};

	document.addEventListener('DOMContentLoaded', onReady);

	setInterval(getUrlList, 1000);

	function getUrlList() {
		console.log('tett');

		let xhr = new XMLHttpRequest();
		xhr.open('GET', API.list, true);
		xhr.send();
		xhr.onreadystatechange = function() {

			if(this.readyState != 4) return;

			if(this.status != 200) {
				console.log(`${this.status} - ${this.statusText}`);
				return false;
			}

			let data = JSON.parse(this.responseText)
			let container = document.getElementById('table-url');
			container.innerHTML = null;
			writeTableData(data, container);

		}
	}

	function writeTableData(data, container) {
		let fragment = document.createDocumentFragment();
		data.forEach((item, index) => {
			let row = document.createElement('tr');
		let cellNum, cellCommand, cellTime, cellUrl;

		cellNum = document.createElement('th');
		cellNum.setAttribute('scope', 'row');
		cellNum.innerHTML = index + 1;
		row.appendChild(cellNum);

		cellCommand = document.createElement('td');
		cellCommand.innerHTML = item.command;
		row.appendChild(cellCommand);

		cellTime = document.createElement('td');
		cellTime.innerHTML = item.time;
		row.appendChild(cellTime);

		cellUrl = document.createElement('td');
		cellUrl.innerHTML = item.url;
		row.appendChild(cellUrl);

		fragment.appendChild(row);

	})

		container.appendChild(fragment)
	}

	function createFormData(command, url, section) {
		let data = new FormData();
		data.append('url', url)
		data.append('command', command);
		if(command === 'del') data.append('section', section);
		return data;
	}

	function onReady() {
		let btn = {
			add: document.querySelector('.js-btn-add'),
			clear: document.querySelector('.js-btn-clear')
		};
		let input = {
			clear: document.querySelector('.js-input-clear'),
			add: document.querySelector('.js-input-add'),
			checkbox: document.querySelector('.js-checkbox-clear')
		};

		btn.add.addEventListener('click', function() {
			if(!input.add.value.length) {
				btn.add.parentElement.parentElement.querySelector('.alert-warning').removeAttribute('hidden');
				btn.add.parentElement.parentElement.querySelector('.alert-success').setAttribute('hidden', true);
				return false;
			} else {
				btn.add.parentElement.parentElement.querySelector('.alert-warning').setAttribute('hidden', true);
				btn.add.parentElement.parentElement.querySelector('.alert-success').removeAttribute('hidden');
				setTimeout(function() {
					btn.add.parentElement.parentElement.querySelector('.alert-success').setAttribute('hidden', true);
				}, 5000);
			}
			let data = createFormData('add', input.add.value)
			sendData(data);
		});

		btn.clear.addEventListener('click', function() {
			if(!input.clear.value.length) {
				btn.clear.parentElement.parentElement.querySelector('.alert-warning').removeAttribute('hidden');
				btn.clear.parentElement.parentElement.querySelector('.alert-success').setAttribute('hidden', true);
				return false;
			} else {
				btn.clear.parentElement.parentElement.querySelector('.alert-warning').setAttribute('hidden', true);
				btn.clear.parentElement.parentElement.querySelector('.alert-success').removeAttribute('hidden');
				setTimeout(function() {
					btn.clear.parentElement.parentElement.querySelector('.alert-success').setAttribute('hidden', true);
				}, 5000);
			}
			let data = createFormData('del', input.clear.value,  input.checkbox.checked)
			sendData(data);
		});


		function sendData(data) {
			let xhr = new XMLHttpRequest();
			xhr.open('POST', API.add, true);
			xhr.send(data);
			xhr.onreadystatechange = function() {
				if(this.readyState != 4) return;
				if(this.status != 200) {
					console.log(`${this.status} - ${this.statusText}`);
					return false;
				}
				console.log(this.responseText);
			}
		}

	}


})();