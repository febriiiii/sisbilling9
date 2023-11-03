
    <style>
        .navbarWrap {
          box-sizing: border-box;
          --bgColorMenu : #4D67AA;
          --duration: .7s; 
          position: fixed;
          bottom: -10px; 
          width: 100%;
        }
        .navbarWrap *,
        .navbarWrap *::before,
        .navbarWrap *::after {

        box-sizing: inherit;

        }


        .menu{
          margin: 0;
          display: flex;
          width: 100%;
          font-size: .8em;
          padding: 0 2.85em;
          position: relative;
          align-items: center;
          justify-content: center;
          background-color: var(--bgColorMenu);
        }

        .menu__item{

        all: unset;
        flex-grow: 1;
        z-index: 100;
        display: flex;
        cursor: pointer;
        position: relative;
        border-radius: 50%;
        align-items: center;
        will-change: transform;
        justify-content: center;
        padding: 0.4em 0 0.7em;
        transition: transform var(--timeOut , var(--duration));

        }

        .menu__item::before{

        content: "";
        z-index: -1;
        width: 3em;
        height: 3em;
        border-radius: 50%;
        position: absolute;
        transform: scale(0);
        transition: background-color var(--duration), transform var(--duration);

        }


        .menu__item.active {

        transform: translate3d(0, -.8em , 0);

        }

        .menu__item.active::before{

        transform: scale(1);
        background-color: var(--bgColorItem);

        }

        .icon{
          width: 2em;
          height: 2em;
          stroke: white;
          fill: transparent;
          stroke-width: 1pt;
          stroke-miterlimit: 10;
          stroke-linecap: round;
          stroke-linejoin: round;
          stroke-dasharray: 400;

        }

        .menu__item.active .icon {

        animation: strok 1.5s reverse;

        }

        @keyframes strok {

        100% {

            stroke-dashoffset: 400;

        }

        }

        .menu__border{

          left: 0;
          bottom: 99%;
          width: 8em;
          height: 2em;
          position: absolute;
          clip-path: url(#menu);
          will-change: transform;
          background-color: var(--bgColorMenu);
          transition: transform var(--timeOut , var(--duration));

        }

        .svg-container {

        width: 0;
        height: 0;
        }


        @media screen and (max-width: 50em) {
          .menu{
              font-size: .8em;
          }
        }
    </style>
    <div class="navbarWrap">
      <div class="navbar">
        <ul class="menu uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-scale-up, uk-animation-fade; connect: .switcher-navbarCustom">
          <li class="menu__item active" style="--bgColorItem: rgb(169, 209, 90);">
            <div class="navbarCustomIconX" title="Sis Billing">
              <lord-icon
                  src="https://cdn.lordicon.com/qjuahhae.json"
                  trigger="click"
                  colors="primary:#ffffff"
                  state="hover"
                  style="width:30px;height:30px">
              </lord-icon>
            </div>
          </li>
          <?php if((session('UIDGlob')->companyid != '' && session('UIDGlob')->scrb > 0) || session('UIDGlob')->superadmin == 1): ?>
          <li class="menu__item" style="--bgColorItem: rgb(169, 209, 90);">
            <div class="navbarCustomIconX" title="Customer">
              <lord-icon
                  src="https://cdn.lordicon.com/kulwmpzs.json"
                  trigger="click"
                  colors="primary:#ffffff"
                  style="width:30px;height:30px">
              </lord-icon>
            </div>
          </li>
          <?php endif; ?>
          <li class="menu__item" style="--bgColorItem: rgb(169, 209, 90);">
            <div class="navbarCustomIconX" title="My Billing">
              <lord-icon
                  src="https://cdn.lordicon.com/isugonwi.json"
                  trigger="click"
                  colors="primary:#ffffff"
                  style="width:30px;height:30px">
              </lord-icon>
            </div>
          </li>
    
          <li class="menu__item" style="--bgColorItem: rgb(169, 209, 90);">
            <div class="navbarCustomIconX" title="Forum">
              <lord-icon
                  src="https://cdn.lordicon.com/hpivxauj.json"
                  trigger="click"
                  colors="primary:#ffffff"
                  style="width:30px;height:30px">
              </lord-icon>
            </div>
          </li>
    
          <li class="menu__item" style="--bgColorItem:rgb(169, 209, 90);">
            <div class="navbarCustomIconX" title="Profile">
              <div style="border: 2px solid #F8F8F8; background-image: url('<?php echo e(asset('public/storage/'.session('UIDGlob')->profileImg)); ?>'); width: 25px; height: 25px; border-radius: 100%; background-position: center; background-size: contain;"></div>
              
            </div>
          </li>
    
          <div class="menu__border"></div>
        </ul>
    
        <div class="svg-container">
          <svg viewBox="0 0 202.9 45.5">
            <clipPath id="menu" clipPathUnits="objectBoundingBox" transform="scale(0.0049285362247413 0.021978021978022)">
              <path d="M6.7,45.5c5.7,0.1,14.1-0.4,23.3-4c5.7-2.3,9.9-5,18.1-10.5c10.7-7.1,11.8-9.2,20.6-14.3c5-2.9,9.2-5.2,15.2-7
                          c7.1-2.1,13.3-2.3,17.6-2.1c4.2-0.2,10.5,0.1,17.6,2.1c6.1,1.8,10.2,4.1,15.2,7c8.8,5,9.9,7.1,20.6,14.3c8.3,5.5,12.4,8.2,18.1,10.5
                          c9.2,3.6,17.6,4.2,23.3,4H6.7z" />
            </clipPath>
          </svg>
        </div>
      </div>
    </div>
    


      <script>
          const menu = document.querySelector(".menu");
          const menuItems = menu.querySelectorAll(".menu__item");
          const menuBorder = menu.querySelector(".menu__border");
          let activeItem = menu.querySelector(".active");
          $('.switcher-navbarCustom').on('shown.uk.switcher', function() {
              var index = $(this).find('.uk-active').index();
              var item = menuItems[index]
              menu.style.removeProperty("--timeOut");
              if (activeItem == item) return;
              if (activeItem) {
                  activeItem.classList.remove("active");
              }
              item.classList.add("active");
              activeItem = item;
              
              offsetMenuBorder(activeItem, menuBorder);
              var title = $('.uk-subnav > li:eq(' + index + ') .navbarCustomIconX').attr('title')
              if(title == 'My Billing'){
                  loadbilling()
              }else if(title == "Customer"){
                  tblcustomer()
              }else if(title == "Sis Billing"){
                  reloadDashboard()
              }else if(title == 'Profile'){
                var formElement = document.getElementById("myprofile-formcompany");
                var inputElements = formElement.querySelectorAll("input");
                var ti = 1000
                inputElements.forEach(function(inputElement) {
                  setTimeout(() => {
                    $(inputElement).click()
                  }, ti);
                  ti = ti + 1000;
                });
              }
              $('title').text(title);
              $('#title').text(title);
          })
          function offsetMenuBorder(element, menuBorder) {
            setTimeout(() => {
                const offsetActiveItem = element.getBoundingClientRect();
                const left = Math.floor(offsetActiveItem.left - menu.offsetLeft - (menuBorder.offsetWidth  - offsetActiveItem.width) / 2) +  "px";
                menuBorder.style.transform = `translate3d(${left}, 0 , 0)`;
              }, 100);
          }
          offsetMenuBorder(activeItem, menuBorder);
          window.addEventListener("resize", () => {
              offsetMenuBorder(activeItem, menuBorder);
              menu.style.setProperty("--timeOut", "none");
          });
      </script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/layout/navbarMobile.blade.php ENDPATH**/ ?>