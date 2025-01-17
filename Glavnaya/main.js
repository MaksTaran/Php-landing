
const app = Vue.createApp({
  data()
  {
     return {
       visible:false,
       rotate:true,
     //   семь выпадающих списков
       visible2:false,
       rotate2:true,
       visible3 :false,
       map:false,
       bigItem:false,
       rotate3:true,
       visible4:false,
       rotate4:true,
       visible5:false,
       rotate5:true,
       visible6:false,
       rotate6:true,
       visible7:false,
       rotate7:true,
       userInfo:false,
       burger:false,
       activeBurger:false,
       visibleCompany:false,

      
     }
    
  },
  
  computed: {
     
  },
  methods: {
  
  BodyScroll(){
     document.body.classList.add('lock');
     
 },
  
  
   
  },
 mounted() {
  window.onload = function () {
    
     document.body.classList.add('loaded_hiding');
     window.setTimeout(function () {
       document.body.classList.add('loaded');
       document.body.classList.remove('loaded_hiding');
     }, 1000);
   }
   document.addEventListener('click',this.hideSelect.bind(this), true)
   
 },
 beforeDestroy() {
  document.removeEventListener('click',this.hideSelect)
 },
  BodyScroll(){
     document.body.classList.add('lock');
     
 },
 disabledBodyscroll(){
  document.body.classList.remove('lock');
 },
 
 

})
app.mount("#app");

// прилоудер



