<template>
  <v-content>

    <v-container grid-list-md text-center >

       <v-card flat tile>
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
      <v-card-title class="yellow">
   <div class="headline">GENERAL REPORT</div>
      </v-card-title>
      <v-card-text >

        <v-layout  wrap>
          <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
            <v-select
            item-text="status"
            item-value="id"
            :items="transaction_status"
            v-model="selected_status"
            label="Select Status"
            return-object
            ></v-select>
          </v-flex>
          <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
           <v-text-field
           v-model="tracking_no"
           label="Tracking No."
           ></v-text-field>
         </v-flex>
         <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
          <v-menu
          v-model="menu"
          :close-on-content-click="false"
          :nudge-right="40"
          lazy
          transition="scale-transition"
          offset-y
          full-width
          min-width="290px"
          >
          <template v-slot:activator="{ on }">
            <v-text-field
            v-model="start_date"
            label="Start Date"
            prepend-icon="event"
            readonly
            v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker v-model="start_date" @input="menu = false"></v-date-picker>
        </v-menu>
      </v-flex>
      <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
       <v-menu
       v-model="menu2"
       :close-on-content-click="false"
       :nudge-right="40"
       lazy
       transition="scale-transition"
       offset-y
       full-width
       min-width="290px"
       >
       <template v-slot:activator="{ on }">
        <v-text-field
        v-model="end_date"
        label="End Date"
        prepend-icon="event"
        readonly
        v-on="on"
        ></v-text-field>
      </template>
      <v-date-picker min="'start_date'" v-model="end_date" @input="menu2 = false"></v-date-picker>
    </v-menu>
  </v-flex>
  <v-flex xs12 sm12 md2 lg2 xl2 >
    <v-btn class="ma-2" tile color="indigo" @click="search"dark>Search</v-btn>
    <v-btn class="ma-2" tile color="indigo" outline dark>Clear</v-btn>
  </v-flex>

</v-layout>

<v-layout  wrap>
  <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
    <h1>Sender</h1>
  </v-flex>
  <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
   <v-text-field
   v-model="sender_f_name"
   label="First Name"
   ></v-text-field>
 </v-flex>
 <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
   <v-text-field
   v-model="sender_m_name"
   label="Middle Name"
   ></v-text-field>
 </v-flex>
 <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
  <v-text-field
  v-model="sender_l_name"
  label="Last Name"
  ></v-text-field>
</v-flex>


</v-layout>
<v-layout  wrap>
  <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
    <h1>Beneficiary</h1>
  </v-flex>
  <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
   <v-text-field
   v-model="beneficiary_f_name"
   label="First Name"
   ></v-text-field>
 </v-flex>
 <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
   <v-text-field
   v-model="beneficiary_m_name"
   label="Middle Name"
   ></v-text-field>
 </v-flex>
 <v-flex xs12 sm12 md2 lg2 xl2 d-flex>
  <v-text-field
  v-model="beneficiary_l_name"
  label="Last Name"
  ></v-text-field>
</v-flex>


</v-layout>

 <v-btn class="ma-2" v-if="desserts.length" tile color="indigo" @click="download" dark >Export</v-btn>


<v-data-table
:headers="headers"
:items="desserts"
class="elevation-1"


>
<template v-slot:items="props">
  <td>{{ props.item.user.fname }} {{ props.item.user.lname }}</td>
  <td>{{ props.item.tracking_no }} </td>
  <td>{{ props.item.created_at }} </td>
  <td>{{ props.item.sender.fname }} {{ props.item.sender.lname }}</td>
  <td>{{ props.item.sender.address }}</td>
  <td>{{ props.item.sender.contact_no }}</td>
  <td>{{ props.item.send_amount }}</td>
  <td>{{ props.item.exchange_rate }}</td>
  <td>{{ props.item.charge_amount }}</td>
  <td>{{ props.item.receive_amount }}</td>
  <td>{{ props.item.beneficiary.fname }} {{ props.item.beneficiary.lname }}</td>
  <td>{{ props.item.beneficiary.address }}</td>
  <td>{{ props.item.beneficiary.contact_no }}</td>
  <td>{{ props.item.beneficiary_service_center.mode_center.service_center.center_desc }}</td>
  <td>{{ props.item.beneficiary_service_center.account_no }}</td>
  <td>{{ props.item.payment_remarks }}</td>
  <td>{{ props.item.beneficiary_service_center.mode_center.service_mode.mode_desc }}</td>
  <td v-if="props.item.completed_by_user !== null">
    {{ props.item.completed_by_user.fname }} {{ props.item.completed_by_user.lname }}
  </td>
  <td v-if="props.item.approved_by_user !== null">
    {{ props.item.approved_by_user.fname }} {{ props.item.approved_by_user.lname }}
  </td>


</template>
</v-data-table>

</v-card-text>

</v-card>
    </v-container>
  </v-content>
</template>

<script>
  export default {
    data () {
      return {
       sender_f_name:'',
       sender_m_name:'',
       sender_l_name:'',
       beneficiary_f_name:'',
       beneficiary_m_name:'',
       beneficiary_l_name:'',
       tracking_no:'',
       selected_status:{id:'',status:'All'},
       start_date: new Date().toISOString().substr(0, 10),
       end_date: new Date().toISOString().substr(0, 10),
       menu: false,
       modal: false,
       menu2: false,
       transaction_status:[],
       loading:true,
       page: 1,
       items: [5, 10, 15, 'All'],
       desserts: [],
       headers: [
       {
        text: 'Created By',
        align: 'left',
        sortable: false,
        value: 'user'
      },
      { text: 'Tracking No.' ,value:'tracking_no'},
      { text: 'Date' ,value:'created_at'},
      { text: 'Sender Name', value: 'sender' },
      { text: 'Sender Address', value: 'sender_address' },
      { text: 'Contact No.', value: 'contact_no' },
      { text: 'Amount AUD', value: 'amount_aud' },
      { text: 'Exchange Rate', value: 'exchange_rate' },
      { text: 'Service Charge', value: 'charge_amount' },
      { text: 'Amount in PHP', value: 'receive_amount' },
      { text: 'Beneficiary Name', value: 'beneficiary' },
      { text: 'Beneficiary Address', value: 'beneficiary_address' },
      { text: 'Beneficiary Contact', value: 'beneficiary_contact' },
      { text: 'Service Center', value: 'service_center' },
      { text: 'Account No.', value: 'account_no' },
      { text: 'Tellers Remarks.', value: 'payment_remarks' },
      { text: 'Service Mode.', value: 'service_mode' },
      { text: 'Completed By.', value: 'completed_by' },
      { text: 'Approved By.', value: 'approved_by' },
      ],


    }
  },
  created () {
    this.initialize()

  },
  methods: {
    initialize () { 
      axios.get('./api/transaction').then(response => {
        this.desserts = response.data

      });
      axios.get('./api/transactionstatus').then(response => {
        this.transaction_status = response.data
        this.transaction_status.push({id:'',status:'All'})

      });
      this.loading = false

    }, 
    search(){
      this.loading = true;

      axios.get('./api/transaction/search',
        {params:
          {
            status_id:this.selected_status.id,
            tracking_no:this.tracking_no,
            start_date:this.start_date,
            end_date:this.end_date,
            sender_f_name:this.sender_f_name,
            sender_l_name:this.sender_l_name,
            sender_m_name:this.sender_m_name,
            beneficiary_f_name:this.beneficiary_f_name,
            beneficiary_l_name:this.beneficiary_l_name,
            beneficiary_m_name:this.beneficiary_m_name,
          } 
        })
      .then(response => {
       this.desserts = response.data

       this.loading = false;
     });


    },
    download(){
     window.location = window.location.origin+"/api/transaction/exports?status_id="+this.selected_status.id+"&tracking_no="+this.tracking_no+"&start_date="+this.start_date+"&end_date="+this.end_date+"&sender_f_name="+this.sender_f_name+"&sender_l_name="+this.sender_l_name+"&sender_m_name="+this.sender_m_name+"&beneficiary_f_name="+this.beneficiary_f_name+"&beneficiary_l_name="+this.beneficiary_l_name+"&beneficiary_m_name="+this.beneficiary_m_name;
   }

 }
}
</script>



