/*
Template Name: Monster Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
$(function() {
    "use strict";
      $(".tst1").click(function(){
           $.toast({
            heading: 'Welcome to Monster admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'info',
            hideAfter: 3000, 
            stack: 6
          });

     });

      $(".tst2").click(function(){
           $.toast({
            heading: 'Welcome to Monster admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'warning',
            hideAfter: 3500, 
            stack: 6
          });

     });
      $(".tst3").click(function(){
           $.toast({
            heading: 'Welcome to Monster admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'success',
            hideAfter: 3500, 
            stack: 6
          });

     });

      $(".tst4").click(function(){
           $.toast({
            heading: 'Welcome to Monster admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'error',
            hideAfter: 3500
            
          });

     });
});

function insert_error(){
  $.toast({
    heading: 'Error!',
    text: 'Terjadi kesalahan ketika memasukkan data. Pastikan data yang anda masukkan telah benar.',
    position: 'top-right',
    loaderBg:'#ff6849',
    icon: 'error',
    hideAfter: 4500
  });
  $('#insert-modal').modal('show');
}

function edit_error(){
  $.toast({
    heading: 'Error!',
    text: 'Terjadi kesalahan ketika memasukkan data. Pastikan data yang anda masukkan telah benar.',
    position: 'top-right',
    loaderBg:'#ff6849',
    icon: 'error',
    hideAfter: 4500
  });
  $('#modal-edit').modal('show');
}

function success(msg){
  $.toast({
    heading: 'Sukses',
    text: msg,
    position: 'top-right',
    loaderBg:'#ff6849',
    icon: 'success',
    hideAfter: 4500
  }); 
}

function error(msg){
  $.toast({
    heading: 'Error',
    text: msg,
    position: 'top-right',
    loaderBg:'#ff6849',
    icon: 'error',
    hideAfter: 5000
  }); 
}

          
