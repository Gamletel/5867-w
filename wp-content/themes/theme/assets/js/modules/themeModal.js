class ThemeModal {
	buttonsCloseModal;
	modalsView = [];
	self;
	instance;
	
	/*========= SETTINGS =======*/
	mouseup = true;
	
	constructor(settings) {
		if(typeof ThemeModal.instance === 'object') {
			return ThemeModal.instance;
		}
		this.buttonsCloseModal = document.querySelectorAll('.close-modal');
		
		if(settings) {
			if(settings.hasOwnProperty('mouseup')) {
				this.mouseup = settings.mouseup;
			}
		}
		
		ThemeModal.instance = this;
		self = this;
		return ThemeModal.instance;
	}
	
	createBackground(){
		if(!document.getElementById('modal-background')) {
			let modalBackground = document.createElement('div');
			modalBackground.id = 'modal-background';
			modalBackground.style.position = 'fixed';
			modalBackground.style.left = '0';
			modalBackground.style.right = '0';
			modalBackground.style.top = '0';
			modalBackground.style.bottom = '0';
			modalBackground.style.background = 'black';
			modalBackground.style.opacity = '0.5';
			modalBackground.style.zIndex = '9999';
			document.querySelector('body').appendChild(modalBackground);
		}
	}
	removeBackground() {
		let bg = document.getElementById('modal-background');
		if (bg != undefined) {
			bg.remove();
		}
	}
	
	openModal(modalId) {
		if(document.getElementById(`modal-${modalId}`)) {
			let modal = document.getElementById(`modal-${modalId}`);
			modal.classList.add('modal-open');
			self.createBackground();
			if(this.mouseup) {
				document.body.addEventListener('mouseup', self.mouseUpHandler);
			}
			
			self.buttonsCloseModal.forEach(function (el,key){
				el.addEventListener('click', self.closeModal);
			});
			
			let event = new Event('modalOpened', {bubbles: true});
			modal.dispatchEvent(event);
		}
	}
	closeModal(ev) {
		
		if(ev !== undefined && ev.target.classList.contains('close-modal')) {
			let parent = ev.target.closest('.theme-modal');
			parent.classList.remove('modal-open');
			let activeModals = document.querySelectorAll('.theme-modal.modal-open');
			
			let event = new Event('modalClosed', {bubbles: true});
			parent.dispatchEvent(event);
			
			if(activeModals.length === 0) {
				self.removeBackground();
				
				if(this.mouseup) {
					document.body.removeEventListener('mouseup', self.mouseUpHandler, false);
				}
				self.buttonsCloseModal.forEach(function (el,key){
					el.removeEventListener('click', self.closeModal, false);
				});
				
			}
			
		}else{
			let modals = document.querySelectorAll('.theme-modal.modal-open');
			modals.forEach(function (el,key){
				el.classList.remove('modal-open');
			});
			self.removeBackground();
			
			if(this.mouseup) {
				document.body.removeEventListener('mouseup', self.mouseUpHandler, false);
			}
			self.buttonsCloseModal.forEach(function (el,key){
				el.removeEventListener('click', self.closeModal, false);
			});
			
		}
		
	}
	openModalHandler(target){
		let modalId = target ? target.getAttribute('data-modal') : ev;
		if(modalId) {
			if (self.modalsView.hasOwnProperty(modalId)){
				self.modalsView[modalId].props = target.attributes;
				let props = self.modalsView[modalId].props;
				let modal = document.getElementById(`modal-${modalId}`);
				self.modalsView[modalId].callback.call(null, modal, props);
			}else{
				self.openModal(modalId);
			}
		}
	}
	mouseUpHandler(e) {
		if (document.querySelector('.theme-modal.modal-open')){
			let activeModals = document.querySelectorAll('.theme-modal.modal-open');
			let show = false;
			activeModals.forEach(function (el,key) {
				if(el.isEqualNode(e.target)  || el.contains(e.target))
				{
					show = true;
				}
			});
			
			if(show === false) {
				self.closeModal();
			}
		}
	}
	
	buttonsListener() {
		let th = this;
		document.addEventListener('click', function(ev){

			if(ev.target && ev.target.dataset) {

				if('modal' in ev.target.dataset) {

					th.openModalHandler(ev.target);

				}else if(ev.target.closest('[data-modal]')) {

					th.openModalHandler(ev.target.closest('[data-modal]'));

				}
			}
		});
	}
	contactFormListener() {
		jQuery(document).on('ajaxformsent', function(){
			self.closeModal();
			self.openModal('success');
			setTimeout(function(){
				self.closeModal();
			}, 2000);
		});
		jQuery(document).on('ajaxformerror', function(){
			self.closeModal();
			self.openModal('error');
			setTimeout(function(){
				self.closeModal();
			}, 2000);
		});
	}
	
	
	
	init() {
		this.buttonsListener();
		this.contactFormListener();
	}

	static getInstance() {
		if(typeof ThemeModal.instance === 'object') {
			return ThemeModal.instance;
		}
		ThemeModal.instance = this;
		return new ThemeModal();
	}
	
	static reinitForms(form = false) {
		let inputTels = document.querySelectorAll('input[type=tel]');
		if(inputTels.length) {
			inputTels.forEach((input) => {
				jQuery(input).inputmask({"mask": "+7 999 999-99-99"});
			});
		}
	}
}


window.ThemeModal = ThemeModal;