<template>
  <v-content >
    <v-dialog v-model="loading" fullscreen full-width>
      <v-container fluid fill-height style="background-color: rgba(255, 255, 255, 0.5);">
        <v-layout justify-center align-center>
          <v-progress-circular
          indeterminate
          color="primary">
        </v-progress-circular>
      </v-layout>
    </v-container>
  </v-dialog>
  <v-container grid-list-md text-center v-if="!loading">

   <div class="text-xs-center">
     <v-dialog
     v-model="pay"
     width = "500"
     >
     <v-card>
      <v-card-title
      class="headline yellow"
      primary-title
      >
      ADD PAYMENT
    </v-card-title>



    <v-card-text>

     <v-text-field
     v-model="total_payment"
     label="Total Payment"
     required
     ></v-text-field>
     <v-text-field
     v-model="bank"
     label="Bank"
     required
     ></v-text-field>
     <v-text-field
     v-model="bank_branch"
     label="Bank Branch"

     ></v-text-field>
     <v-menu
     ref="menu"
     v-model="menu"
     :close-on-content-click="false"
     :nudge-right="40"
     :return-value.sync="date"
     lazy
     transition="scale-transition"
     offset-y
     full-width
     min-width="290px"
     >
     <template v-slot:activator="{ on }">
      <v-text-field
      v-model="date"
      label="Date Posted"
      prepend-icon="event"
      readonly
      v-on="on"
      ></v-text-field>
    </template>
    <v-date-picker v-model="date" no-title scrollable>
      <v-spacer></v-spacer>
      <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
      <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
    </v-date-picker>
  </v-menu>


</v-card-text>

<v-divider></v-divider>

<v-card-actions>
  <v-spacer></v-spacer>
  <v-btn
  color="warning"
  flat
  @click="pay = false;add_payment()"
  >
  OK
</v-btn>
</v-card-actions>
</v-card>
</v-dialog>
<v-dialog
v-model="dialog"
width = "50%"
>
<v-card>
  <v-card-title
  class="headline yellow"
  primary-title
  >
  PAYMENTS
</v-card-title>
<v-dialog v-model="loading_payments" fullscreen full-width>
  <v-container fluid fill-height style="background-color: rgba(255, 255, 255, 0.5);">
    <v-layout justify-center align-center>
      <v-progress-circular
      indeterminate
      color="primary">
    </v-progress-circular>
  </v-layout>
</v-container>
</v-dialog>
<div v-if="!loading_payments">
  <v-card-title>
    Payments
    <v-spacer></v-spacer>
    <v-text-field
    v-model="search1"
    append-icon="search"
    label="Search"
    single-line
    hide-details
    ></v-text-field>
  </v-card-title>
  <v-data-table
  :headers="headers1"
  :items="desserts1"
  :search="search1"
  >
  <template v-slot:items="props">
    <td class="text-xs-left">AUD {{ props.item.payment_amount }}</td>
    <td class="text-xs-left">{{ props.item.bank }}</td>
    <td class="text-xs-left">{{ props.item.bank_branch }}</td>
    <td class="text-xs-left">{{ props.item.date_posted }}</td>
  </template>
  <template v-slot:no-results>
    <v-alert :value="true" color="error" icon="warning">
      Your search for "{{ search }}" found no results.
    </v-alert>
  </template>
</v-data-table>
</div>


<v-card-text>

</v-card-text>

<v-divider></v-divider>

<v-card-actions>
  <v-spacer></v-spacer>
  <v-btn
  color="warning"
  flat
  @click="dialog = false;"
  >
  OK
</v-btn>
</v-card-actions>
</v-card>
</v-dialog>
</div>
<v-card>
  <v-card-title class="yellow">
 <div class="headline">BRANCH PAYMENT</div>
    <v-spacer></v-spacer>
    <v-text-field
    v-model="search"
    append-icon="search"
    label="Search"
    single-line
    hide-details
    ></v-text-field>
  </v-card-title>
  <v-data-table
  :headers="headers"
  :items="desserts"
  :search="search"
  disable-initial-sort
  >
  <template v-slot:items="props"  >

    <td>
      <div v-if="props.item.id != 1">
        BRANCH
      </div>

      {{ props.item.business_name }}
    </td>

    <td class="text-xs-left">AUD {{ props.item.total_payable }}  </td>
    <td class="text-xs-left">AUD {{ props.item.total_branch_payment }}</td>
    <td class="text-xs-left">
      <v-btn outline color="indigo" @click="view_payment(props.item.id)">
        VIEW PAYMENTS
      </v-btn>
    </td>
    <td class="text-xs-left">
      <v-btn outline color="indigo" @click="add_payment_modal(props.item.id)">
        ADD PAYMENT
      </v-btn>
    </td>


  </template>
  <template v-slot:no-results>
    <v-alert :value="true" color="error" icon="warning">
      Your search for "{{ search }}" found no results.
    </v-alert>  
  </template>
</v-data-table>
</v-card>
</v-container>

</v-container>
</v-content>
</template>

<script>
  export default {
    data () {
      return {
        loading_payments:false,
        loading:true,
        total_payment:null,
        bank:null,
        bank_branch:null,
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        remarks:null,
        pay:false,
        dialog:false,
        id:null,
        search: '',
        search1: '',
        headers1:[
        {text : "AMOUNT PAY",value: "payment_amount"},
        {text : "BANK",value: "bank"},
        {text : "BRANCH",value: "branch"},
        {text : "DATE POSTED",value: "date_posted"},
        ],
        headers: [
        { text: 'BUSINESS NAME', value: 'business_name'},
        { text: 'TOTAL PAYABLE', value: 'agent_code' },
        { text: 'TOTAL BRANCH PAYMENT', value: 'owner' },
        { text: 'VIEW PAYMENTS', value: '' },
        { text: 'ADD PAYMENTS', value: '' },

        ],
        desserts: [],
        desserts1: []
      }
    },methods: {
      initialize () { 
        axios.get('./api/agent/payment').then(response => {
          this.desserts = response.data
          this.loading= false
        });
        
      },
      view_payment(id){
        this.desserts1 = []
        this.loading_payments= true
        axios.get('./api/agent_payment/agent/'+id).then(response => {
          this.desserts1 = response.data
          this.loading_payments= false
        });

        this.dialog = true;
      },
      add_payment_modal(id){
        this.id = id;
        this.pay = true;

      },
      add_payment(){
        var id = this.id
        axios.post('./api/agent_payment/',{id:id,payment_amount:this.total_payment,bank:this.bank,bank_branch:this.bank_branch,date_posted:this.date}).then(response => {
          this.desserts = response.data
        });
      }
    },
    created () {
      this.initialize()
    }
  }
</script>


