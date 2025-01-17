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

       rotateCompany:true,
       
       nach:'Sota «Сенная» - 14шт',
       nach2:'Sota Юнона - 9шт',
       nach3:'Sota Юнона - 9шт',
       nach4:'«Ленинский пр, 192» - 10шт',
       nach5:'«Ленинский пр, 192» - 5шт',
       nach6:'Liberti «Удельная» - 3шт',
       nach7:'Liberti «Удельная» - 9шт',
       selectedCompany:'RemBrand',
       punkts:[
        {name:'Администратор',value:1},
        {name:'Веб-разработчик',value:2},
        {name:'Начальник отдела',value:3},
       ],
       nalichie:[
        {name:'Sota «Сенная» - 14шт',value:1},
        {name:'Sota «Леннина» - 8шт',value:2},
        {name:'Sota «Павелецкая» - 4шт',value:3},
       ],
       nalichie2:[
        {name:'Sota «Юнона» - 9шт',value:1},
        {name:'Sota «Третьяковская» - 5шт',value:2},
        {name:'Sota «Павелецкая» - 10шт',value:3},
       ],
       nalichie3:[
        {name:'Sota «Юнона» - 9шт',value:1},
        {name:'Sota «Маяковская» - 1шт',value:2},
        {name:'Sota «Селигерская» - 4шт',value:3},
       ],
       nalichie4:[
        {name:'«Ленинский пр, 192» - 10шт',value:1},
        {name:'«Войковская» - 25шт',value:2},
        {name:'«Павелецкая» - 4шт',value:3},
       ],
       nalichie5:[
        {name:'«Ленинский пр, 192» - 10шт',value:1},
        {name:'«Ленина 25» - 6шт',value:2},
        {name:'«Гагарина 4» - 11шт',value:3},
       ],
       nalichie6:[
        {name:'Liberti «Удельная» - 3шт',value:1},
        {name:'Liberti «Заводская» - 7шт',value:2},
        {name:'«Авиамоторная» - 18шт',value:3},
       ],
       nalichie7:[
        {name:'Liberti «Удельная» - 9шт',value:1},
        {name:'«Царицино» - 2шт',value:2},
        {name:'Liberti «Павелецкая» - 13шт',value:3},
       ],
       punktsCompany:[
        {name:'RemBrand',value:1,countPeople:5},
        {name:'Micro PC',value:2,countPeople:15},
        {name:'Big MC',value:3,countPeople:1},
        {name:'Apple',value:3,countPeople:2},
       ]
     }
    
  },
  
  computed: {
     submenuArrow: function() {
        if(this.rotate == true) {
           return 'submenuArow'
        } else {
           return 'activeRotate'
        }
     },
     submenuArrow2: function() {
        if(this.rotate2 == true) {
           return 'submenuArow'
        } else {
           return 'activeRotate'
        }
     },
     submenuArrow3: function() {
        if(this.rotate3 == true) {
           return 'submenuArow'
        } else {
           return 'activeRotate'
        }
     },
     submenuArrow4: function() {
        if(this.rotate4 == true) {
           return 'submenuArow'
        } else {
           return 'activeRotate'
        }
     },
     submenuArrow5: function() {
        if(this.rotate5 == true) {
           return 'submenuArow'
        } else {
           return 'activeRotate'
        }
     },
     submenuArrow6: function() {
        if(this.rotate6 == true) {
           return 'submenuArow'
        } else {
           return 'activeRotate'
        }
     },
     submenuArrow7: function() {
        if(this.rotate7 == true) {
           return 'submenuArow'
        } else {
           return 'activeRotate'
        }
     },
     submenuCompanyArrow: function() {
        if(this.rotateCompany == true) {
           return 'submenuArow2'
        } else {
           return 'activeRotate'
        }
     }
  },
  methods: {
  punktSelect(punkt){
    this.selected = punkt.name;
   
  },
  nalichieSelect(nalichie){
     this.nach = nalichie.name;
   },
   nalichieSelect2(nalichie2){
     this.nach2 = nalichie2.name;
   },
   nalichieSelect3(nalichie3){
     this.nach3 = nalichie3.name;
   },
   nalichieSelect4(nalichie4){
     this.nach4 = nalichie4.name;
   },
   nalichieSelect5(nalichie5){
     this.nach5 = nalichie5.name;
   },
   nalichieSelect6(nalichie6){
     this.nach6 = nalichie6.name;
   },
   nalichieSelect7(nalichie7){
     this.nach7 = nalichie7.name;
   },
  BodyScroll(){
     document.body.classList.add('lock');
     
 },
  punktCompanySelect(punktCompany){
     this.selectedCompany = punktCompany.name;
     
   },
   hideSelect(){
     this.visible = false;
     this.rotate=true;
     // семь различных списков
     this.visible2 = false;
     this.rotate2=true;
     this.visible3 = false;
     this.rotate3=true;
     this.visible4 = false;
     this.rotate4=true;
     this.visible5 = false;
     this.rotate5=true;
     this.visible6 = false;
     this.rotate6=true;
     this.visible7 = false;
     this.rotate7=true;

     this.visibleCompany = false;
     this.rotateCompany=true;
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



