function ready(fn) {
  if (document.readyState != 'loading'){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

ready(
  function() {
    var community = document.getElementById('mnv-citiesBlock');
    if (community) {
      Vue.component('city-item', {
        props: ['city'],
        template: `
          <a href="javascript:;" class="mnv-homeBlock-imageCircle item col-md-2 col-xs-6 col-sm-4">
            <label :for="city.name" v-bind:style="{ 'background-image': 'url(' + city.image + ')' }">
              <p>{{ city.name }}</p>
            </label>
          </a>
        `
      });
      fetch(localStorage.getItem('api_url') + '/community/' + community.dataset.communityId + '/cities').then(function(response) {
        return response.json();
      }).then(function(cities) {
        new Vue({
          el: '#mnv-citiesBlock',
          data: {
            cities: cities
          }
        });
      });
    }
  }
);

ready(
  function() {
    var email = document.querySelector('.mnv-avatar-header');
    if (email) {
      fetch(localStorage.getItem('api_url') + '/user/avatar?email=' + encodeURIComponent(email.dataset.userEmail)).then(function(response) {
        return response.json();
      }).then(function(data) {
        new Vue({
          el: '.mnv-avatar-header',
          data: {
            avatar: data.avatar
          }
        });
      });
    }
  }
);

ready(
  function() {
    var email = document.querySelector('.mnv-avatar-sidebar');
    if (email) {
      fetch(localStorage.getItem('api_url') + '/user/avatar?email=' + encodeURIComponent(email.dataset.userEmail)).then(function(response) {
        return response.json();
      }).then(function(data) {
        new Vue({
          el: '.mnv-avatar-sidebar',
          data: {
            avatar: data.avatar
          }
        });
      });
    }
  }
);

ready(
  function() {
    var communities = document.getElementById('mnv-communitiesBlock');
    if (communities) {
      Vue.component('community-item', {
        props: ['community'],
        template: `
          <a :href="'?c=' + community.name" class="mnv-homeBlock-imageCircle item col-md-2 col-xs-6 col-sm-4">
            <label :for="community.name" v-bind:style="{ 'background-image': 'url(' + community.image + ')' }">
              <p>{{ community.name }}</p>
            </label>
          </a>
        `
      });
      fetch(localStorage.getItem('api_url') + '/communities').then(function(response) {
        return response.json();
      }).then(function(communities) {
        new Vue({
          el: '#mnv-communitiesBlock',
          data: {
            communities: communities
          }
        });
      });
    }
  }
);

ready(
  function() {
    var headerCommunity = document.querySelector('.mnv-homeBlock-community');
    if (headerCommunity) {
      fetch(localStorage.getItem('api_url') + '/community/' + headerCommunity.dataset.communityId).then(function(response) {
        return response.json();
      }).then(function(data) {
        document.querySelector('.mnv-community-image').style.backgroundImage = "url('" + data.image + "')";
        if (data.icon) {
          document.querySelector('.mnv-community-icon').setAttribute('src', data.icon);
        } else {
          document.querySelector('.mnv-community-iconBlock').remove();
        }
      });
    }
  }
);

ready(
  function() {
    var photoCommunity = document.querySelectorAll('.mnv-photo-community');
    if (photoCommunity && photoCommunity.length > 0) {
      photoCommunity.forEach(element => {
        fetch(localStorage.getItem('api_url') + '/community/' + element.dataset.communityId).then(function(response) {
          return response.json();
        }).then(function(data) {
          element.style.backgroundImage = "url('" + data.image + "')";
        });
      });
    }
  }
);

ready(
  function() {
    Vue.component('event-item', {
      props: ['event'],
      template: `
        <div class="information-block">
          <h3>{{ event.name }}</h3>
          <p>{{ event.event_type.name }}</p>
          <a :href="event.link" v-if="event.link" target="_blank">
            <i class="fas fa-link"></i>
            {{ event.link.substring(0, 26) }}<span v-if="event.link.length > 26">...</span>
          </a>
        </div>
      `
    });
    fetch(localStorage.getItem('api_url') + '/events/all').then(function(response) {
      return response.json();
    }).then(function(events) {
      new Vue({
        el: '#mnv-eventsBlock',
        data: {
          events: events
        }
      });
    });
  }
);

ready(
  function() {
    var community = document.getElementById('mnv-communityDataBlock');
    if (community) {
      fetch(localStorage.getItem('api_url') + '/community/data/' + community.dataset.communityId).then(function(response) {
        return response.json();
      }).then(function(data) {
        new Vue({
          delimiters: ['${', '}'],
          el: '#mnv-communityDataBlock',
          data: {
            community: data
          }
        });
      });
    }
  }
);

ready(
  function() {
    var postText  = document.querySelectorAll('.post-text');
    for (let value of postText) {
      linkifyElement(value, {}, document);
    }
  }
)

ready(
  function() {
    Vue.component('NotificationLineControls', {
      template: `
        <ul>
          <li class="hide-icon">
              <span>...</span>
              <div class="hover-tooltip">
                  <p v-on:click.prevent="removeNotification($event)" class="text">Hide notification</p>
              </div>
          </li>
          <li class="read-icon">
              <span></span>
              <div class="hover-tooltip">
                  <p v-on:click.prevent="markNotification($event)" class="text">Mark as read</p>
              </div>
          </li>
      </ul>
      `,
      props: ['itemId'],
      methods: {
        removeNotification: function(e) {
          fetch('/profile/ajax-remove-notification-' + this.itemId, {credentials: "same-origin"}).then(function(data) {
            e.target.closest('.list-item').remove();
          })
          this.decreaseBellAmount()
        },
        markNotification: function(e) {
          fetch('/profile/ajax-mark-notification-' + this.itemId, {credentials: "same-origin"}).then(function(data) {
            e.target.closest('.list-item').classList.remove('active');
          })
          this.decreaseBellAmount()
        },
        decreaseBellAmount: function() {
          var bellAlert = document.getElementById('bell-alert')
          var amount = parseInt(bellAlert.innerText)
          if(amount != 0) {
            amount -= 1
          }
          bellAlert.innerText = amount
          if(amount == 0) {
            bellAlert.classList.remove('active')
          }
        }
      }
    });

    Vue.component('NotificationControls', {
      template: `
        <div>
          <a href="javascript:;" class="right icon icon-settings mnv-disabled"></a>
          <a href="javascript:;" v-on:click.prevent="markAllAsRead" class="right">Mark all as read</a>
        </div>
      `,
      methods: {
        markAllAsRead: function() {
          var self = this;
          var userLink = document.getElementById('user-link')

          var formData  = new FormData();
          formData.append('email', userLink.dataset.userEmail);

          fetch(localStorage.getItem('api_url') + '/notifications/mark_all_read', {
            method: 'POST',
            body: formData
          }).then(function(response) {
            return response.json()
          }).then(function(data) {
            if (data.status == 'success') {

              var activeRows = document.querySelectorAll('.notifications-popup .list li.active');
              for(activeRow of activeRows){
                activeRow.classList.remove('active')
              }
              var bellAlert = document.getElementById('bell-alert')
              bellAlert.innerHtml = '0'
              bellAlert.classList.remove('active')
            }
          }).catch(function(err) {
            console.log(err)
          })
        }
      }
    });
    var el = document.querySelector('.notifications-popup');
    new Vue({
      el: el
    })
  }
)
