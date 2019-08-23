<template>
  <v-app id="inspire">
    <v-navigation-drawer
    v-model="drawer"
    :clipped="$vuetify.breakpoint.lgAndUp"
    fixed
    app
    class="yellow accent-3 bottom-gradient"
    >
    <v-img  src="https://cdn.vuetifyjs.com/images/parallax/material.jpg">
      <v-layout pa-2 column fill-height class="lightbox black--text">
        <v-spacer></v-spacer>
        <v-avatar size="100">
          <img src="https://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar" >
        </v-avatar>
        <v-flex shrink>
          <strong>
            <div class="subheading">{{user && user.fname}} {{ user && user.lname}}</div>
            <div class="body-1">{{user && user.email}} 
              <v-menu right   transition="slide-x-transition">
                <template v-slot:activator="{ on }">
                  <v-btn
                  icon
                  v-on="on"
                  >
                  <v-icon >settings</v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-tile
                v-for="(setting, index) in settings"
                :key="index"
                @click=""
                class="tile"
                >
                <v-list-tile-title @click="routemenu(setting.to)">{{ setting.title }}</v-list-tile-title>
              </v-list-tile>
            </v-list>
          </v-menu>

        </div>

      </strong>

    </v-flex>
  </v-layout>
</v-img>
<v-list dense>
 

  <template v-for="item in items">
    <v-layout
    v-if="item.heading"
    :key="item.heading"
    row
    align-center
    >
    <v-flex xs6>
      <v-subheader v-if="item.heading">
        {{ item.heading }}
      </v-subheader>
    </v-flex>
    <v-flex xs6 class="text-xs-center">
      <a href="#!" class="body-2 black--text">EDIT</a>
    </v-flex>
  </v-layout>
  <v-list-group
  v-else-if="item.children"
  :key="item.text"
  v-model="item.model"
  :prepend-icon="item.model ? item.icon : item['icon-alt']"
  append-icon=""
  >
  <template v-slot:activator>
    <v-list-tile>
      <v-list-tile-content>
        <v-list-tile-title>
          {{ item.text }}
        </v-list-tile-title>
      </v-list-tile-content>
    </v-list-tile>
  </template>
  <v-list-tile
  v-for="(child, i) in item.children"
  :key="i"
  @click=""
  >
  <v-list-tile-action v-if="child.icon">
    <v-icon>{{ child.icon }}</v-icon>
  </v-list-tile-action>
  <v-list-tile-content>
    <v-list-tile-title @click="routemenu(child.to)">
      {{ child.text }} 
    </v-list-tile-title>
  </v-list-tile-content>
</v-list-tile>
</v-list-group>
<v-list-tile v-else :key="item.text" @click="">
  <v-list-tile-action>
    <v-icon>{{ item.icon }}</v-icon>
  </v-list-tile-action>
  <v-list-tile-content>
    <v-list-tile-title @click="routemenu(item.to)">
      {{ item.text }}
    </v-list-tile-title>
  </v-list-tile-content>
</v-list-tile>
</template>
</v-list>
</v-navigation-drawer>
<v-toolbar
:clipped-left="$vuetify.breakpoint.lgAndUp"
color="grey darken-2"
dark
app
fixed
>
<v-toolbar-title style="width: 300px" class="ml-0 pl-3" >
  <v-toolbar-side-icon  @click.stop="drawer = !drawer"></v-toolbar-side-icon>

  <v-avatar size="100px" tile>
    <img
    :src="'../storage/img/Peramax Logo.svg'"
    alt="Vuetify"
    >
  </v-avatar>

</v-toolbar-title>
<v-text-field
flat
solo-inverted
hide-details
prepend-inner-icon="search"
label="Search"
class="hidden-sm-and-down"
></v-text-field>
<v-spacer></v-spacer>

<v-menu offset-y   transition="slide-y-transition">
  <template v-slot:activator="{ on }">
    <v-btn
    icon
    v-on="on"
    >
    <v-icon large>notifications</v-icon>
  </v-btn>
</template>
<v-list>
  <v-list-tile
  v-for="(item, index) in items"
  :key="index"
  @click=""
  class="tile"
  >
  <v-list-tile-title >{{ item.text }}</v-list-tile-title>
</v-list-tile>
</v-list>
</v-menu>


</v-toolbar>
<router-view>
</router-view>
<!-- 
<v-btn
fab
bottom
right
color="pink"
dark
fixed
@click="dialog = !dialog"
>
<v-icon>add</v-icon>
</v-btn> -->
<v-dialog v-model="dialog" width="800px">
  <v-card>
    <v-card-title
    class="grey lighten-4 py-4 title"
    >
    Create contact
  </v-card-title>
  <v-container grid-list-sm class="pa-4">
    <v-layout row wrap>
      <v-flex xs12 align-center justify-space-between>
        <v-layout align-center>
          <v-avatar size="40px" class="mr-3">
            <img
            src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png"
            alt=""
            >
          </v-avatar>
          <v-text-field
          placeholder="Name"
          ></v-text-field>
        </v-layout>
      </v-flex>
      <v-flex xs6>
        <v-text-field
        prepend-icon="business"
        placeholder="Company"
        ></v-text-field>
      </v-flex>
      <v-flex xs6>
        <v-text-field
        placeholder="Job title"
        ></v-text-field>
      </v-flex>
      <v-flex xs12>
        <v-text-field
        prepend-icon="mail"
        placeholder="Email"
        ></v-text-field>
      </v-flex>
      <v-flex xs12>
        <v-text-field
        type="tel"
        prepend-icon="phone"
        placeholder="(000) 000 - 0000"
        mask="phone"
        ></v-text-field>
      </v-flex>
      <v-flex xs12>
        <v-text-field
        prepend-icon="notes"
        placeholder="Notes"
        ></v-text-field>
      </v-flex>
    </v-layout>
  </v-container>
  <v-card-actions>
    <v-btn flat color="primary">More</v-btn>
    <v-spacer></v-spacer>
    <v-btn flat color="primary" @click="dialog = false">Cancel</v-btn>
    <v-btn flat @click="dialog = false">Save</v-btn>
  </v-card-actions>
</v-card>
</v-dialog>
</v-app>
</template>

<script>
  export default {

   data:() =>({
     settings: [

     { title: 'Logout', to: 'logout' },
     ],
     user:null,
      //layout
      dialog: false,
      drawer: null,
      items: [
      { icon: 'dashboard', text: 'Dashboard', to:'dashboard'},
      { icon: 'supervisor_account', text: 'Direct User Approval', to:'directUserApproval' },
      {
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Transaction',
        model: false,
        children: [
        {  text: 'Create Transaction', to:'transactions/createTransaction' },
        {  text: 'List of Transaction', to:'transactions/listOfTransaction'},
        {  text: 'Branch Payment', to:'transactions/branchPayment'},  
        {  text: 'Hold Branch', to:'transactions/holdBranch'}
        ]
      },
      {
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Report',
        model: false,
        children: [
        { text: 'General Reports', to:'reports/generalReports' },
        { text: 'AUSTRAC Reports', to:'reports/austracReport' },
        { text: 'Counts', to:'reports/counts'},
        { text: 'Certificate', to:'reports/certificate' },
        { text: 'Mlhuillier', to:'reports/mlhuilier' },
        { text: 'Bank to Bank', to:'reports/bankToBank' }
        ]
      },
      {
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Maintenance',
        model: false,
        children: [
        { text: 'Users', to: 'maintenance/users' },
        { text: 'Senders', to: 'maintenance/sender' },
        { text: 'Branches', to: 'maintenance/branches' },
        { text: 'Service Models', to: 'maintenance/serviceModels' },
        { text: 'Service Centers', to: 'maintenance/serviceCenters' },
        { text: 'Exchange Rate', to: 'maintenance/exchangeRate' }
        ]
      },
      { icon: 'library_books', text: 'Logs', to:'logs' },



      ]
    }),
   props: {
    source: String
  },

  methods:{
    routemenu(menuname){
      if(menuname == "logout"){
        window.location.href = "/logout"
      }
      this.$router.push({name: menuname})
    }
  },


  created(){
      // this.$router.push({name: 'dashboard'})
     // get the user
     // axios.get('./getUser')
     // .then(response => this.user = response.data)

   }

 }
</script>
<style scoped>
.tile {
  margin: 5px;
  border-radius: 4px;
}
.tile:hover {
  background: #FFFF8D;
}
.tile:active {
  background: yellow;
}

</style>