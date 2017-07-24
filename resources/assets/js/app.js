require('./bootstrap');

import UserBlock from './components/UserBlock.vue';
import SearchArticle from './components/SearchArticle.vue';
if ($('#u-search').length > 0) {
	new Vue({
	    el: '#u-search',
	    components: { UserBlock },
		data() {
			return {
			    url: '/users/',
			    form: new Form({ search: '', department: '', position: '', city: '' }),
			    ausers: {},
			    users: {},
			    is_visible: false,
			    selects_visible: false,
			};
		},

		methods: {
			dropSearch () {     
			this.form.get('/users/search-bar?search='+this.form.search + '&city=' + this.form.city + '&department=' + this.form.department  + '&position=' + this.form.position)
			    .then(response => this.users = response);
			},

			searchSubmit(){
			  this.form.get('/users/search-submit?search='+this.form.search + '&city=' + this.form.city + '&department=' + this.form.department  + '&position=' + this.form.position)
			      .then(response => {
			      	this.ausers = response;
			      	this.is_visible = false;
			      }
			      	);
			},
			showDrop(){
			  this.is_visible = true;
			},
			hideDrop(){
			  this.is_visible = false;
			},
			toggleSelects(){
			  this.selects_visible = !this.selects_visible;
			  if(!this.selects_visible)
			  {
			  	this.clearSelects();
			  }
			},
			clearSelects(){
				this.form.department = '';
				this.form.position = '';
				this.form.city = '';
			},
		},			
	});
}

if ($('#article-search').length > 0) {
	new Vue({
		components: {SearchArticle},
		el: '#article-search'
	});
}

import MainArticleBlock from './components/MainArticleBlock.vue';

if ($('#main-page').length > 0) {
	new Vue({
		components: {MainArticleBlock},
		el: '#main-page'
	});
}

import PollForm from './components/PollForm.vue';

if ($('#poll-form').length > 0) {
	new Vue({
		components: {PollForm},
		el: '#poll-form'
	});
}

import BidForm from './components/BidForm.vue';

if ($('#crebid').length > 0) {
	new Vue({
		components: {BidForm},
		el: '#crebid'
	});
}
import BidModal from './components/BidModal.vue';
if ($('#userb').length > 0) {	
	new Vue({
		components: {BidModal},
		data: {
			showSuccess: true,
		},
        el : '#userb',
    });
}
        
if ($('#single_article').length > 0) {	
	new Vue({
        el : '#single_article',
        data: {
        	parent_id: null,
        },

        methods: {
        	answerTo(parent_id) {
        		this.parent_id = parent_id;
        		Vue.nextTick(function() {
			        $("#comment").focus();
			    });        		
        	}
        }
    });
}

$(document).ready(function() { 
    $('.menu_item > span').on('click', function(event) {
        event.preventDefault();
        $('.subMenu').css({'visibility':'visible', 'opacity':'1'});
    });
    
    $(document).on('click', function(e) {
        if (!$(e.target).closest(".menu_item").length) {
            $('.subMenu').css({'visibility':'none', 'opacity':'0'});
        }
        e.stopPropagation();
    });
	$('.comment_bClick').focus(function(){
		$('.btn_addComment').css({'visibility':'visible', 'height':'100%'});
		$('.comment_bClick').css({'min-height':'70px'});
	});

	$('.btn_addComment input[type=submit]').on('click', function(event) {
		event.preventDefault();
		$('.btn_addComment').css({'visibility':'hidden', 'height':'0px'});
		$('.comment_bClick').css({'min-height':'40px'});
	});

	/*-------комментарии-------*/
	$(".showComments").click(function() {
	  $(".comment_collapsed").toggle(200);
	});

	/*-------go top button-----*/
	$(".goTopBtn").hide();
	    // fade in
	    $(function () {
	        $(window).scroll(function () {
	            if ($(this).scrollTop() > 100) {
	                $('.goTopBtn').fadeIn();
	            } else {
	                $('.goTopBtn').fadeOut();
	            }
	        });
	        // scroll body to 0px on click
	        $('.goTopBtn').click(function () {
	            $('body,html').animate({
	                scrollTop: 0
	            }, 800);
	            return false;
	        });
	    });
});
    
