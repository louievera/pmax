<template>
  <!-- Content - start Router view-->
  <v-content>
    <v-container grid-list-md text-center>
      <v-layout wrap  justify-space-around >
        <v-flex xs12 md8 lg5>
          <!-- Transactions -->
          <v-card>
            <v-card-title class="yellow">Transactions</v-card-title>
            <v-card-text>  
             <apexchart type=donut width=380 :options="chartOptions" :series="arrChart" />
           </v-card-text>
         </v-card>
         
         <br>
         <!-- Total Daily Transaction -->
         <v-card>
          <v-card-title class="yellow">Total Daily Transaction</v-card-title>
          <v-card-text>  
            <v-data-table
            :headers="headers_daily"
            :items="dailyTransaction"
            class="elevation-1"
            hide-actions

            >
            <template v-slot:items="props">
              <td>{{ props.item.agentCode }}</td>
              <td class="text-xs-left">{{ props.item.serviceCharge }}</td>
              <td class="text-xs-left">{{ props.item.count }}</td>
              <td class="text-xs-left">AUD {{ props.item.totalPayment }}</td>
            </template>
            <template v-slot:footer>
              <tr>
               <td :colspan="2">
                <strong>Total</strong>
              </td>



              <td  class="text-xs-left"><b>{{total_count}}</b></td>
              <td></td>
            </tr>
            <tr>
             <td >
              <strong>Total Payment</strong>
            </td>
            <td :colspan="3" class="text-xs-right"><b>AUD {{total_payment}}</b></td>
          </tr>
        </template>

      </v-data-table>
    </v-card-text>
  </v-card>
  <br>
  <v-card>
   <!-- Agent Payables -->
   <v-card-title class="yellow">Agent Payables</v-card-title>
   <v-card-text> 
     <v-data-table
     :headers="headers_payables"
     :items="agentPayables"
     class="elevation-1"
     hide-actions

     >
     <template v-slot:items="props">      
      <td class="text-xs-left">{{ props.item.TotalPayable }}</td>
      <td class="text-xs-left">{{ props.item.TotalAgentPayment }}</td>
      <td class="text-xs-left">{{ props.item.TotalAgentBalance }}</td>
    </template>


  </v-data-table>
</v-card-text>
</v-card>

</v-flex>
<v-flex xs12 md2 lg4>
  <v-card >
   <!-- Exchange Rate -->
   <v-card-title class="yellow">Exchange Rate</v-card-title>
   <v-card-text>  
    <span class="left">{{exchangeRate.created_at | moment("MMMM D, Y")}}</span><br>
    <span class="left">{{exchangeRate.created_at | moment("dddd")}}</span>

    <span class="right">{{exchangeRate.created_at | moment("hh:mm a")}}</span>
    <br>
    <h1><p class="text-md-center">AUD <i class="material-icons">arrow_right_alt</i> PHP</p></h1>
    <h3><p class="text-md-center">{{exchangeRate.rate}}</p></h3>

  </v-card-text>
</v-card>
<br>
<v-card >
  <!-- Logs of Transactions -->
  <v-card-title class="yellow">Logs of Transactions</v-card-title>
  <v-card-text>  
   <v-data-table
   :headers="headers_logs"
   :items="transactionLogs"
   class="elevation-1"
   hide-actions

   >
   <template v-slot:items="props">
    <td>{{ props.item.trackingNo }}</td>
    <td class="text-xs-left">{{ props.item.createdAt }}</td>
    
  </template>

</v-data-table>

<v-btn block class="primary" @click="routemenu('transactions/listOfTransaction')">Show All</v-btn>

</v-card-text>
</v-card>
</v-flex>
<v-flex xs12 md2 lg3>
  <v-card >
    <!-- Service Charge -->
    <v-card-title class="yellow">Service Charge</v-card-title>
    <v-card-text>  
     <v-data-table
     :headers="headers_charge"
     :items="serviceCharges"
     class="elevation-1"
     hide-actions

     >
     <template v-slot:items="props">
      <td>{{ props.item.name }}</td>
      <td class="text-xs-right">P{{ props.item.service_charge }}</td>
    
      
    </template>

  </v-data-table>
</v-card-text>
</v-card>
</v-flex>

</v-layout>
</v-container>
</v-content>
<!-- End Content - end Router view-->
</template>

<script>
  export default{
   data: () => ({
       //table total daily logs
      headers_charge: [
        {
          text: 'Service Center',
          value: 'name'
        },
        { 
          text: 'Fees', 
          value: 'service_charge' 
        },
      ],
      serviceCharges: [],
      //end table total daily logs

      exchangeRate:[],
        //table total daily logs
        headers_logs: [
        {
          text: 'Tracking number',
          value: 'trackingNo'
        },
        { text: 'Date and Time', value: 'createdAt' },


        ],
        transactionLogs: [       
      ],//end table total daily logs

       //table total daily payables
       headers_payables: [
       {
        text: 'Total Payable',
        value: 'TotalPayable'
      },
      { 
        text: 'Total Payment', 
        value: 'TotalAgentPayment' 
      },
      { 
        text: 'Toyal Balance/Credit', 
        value: 'TotalAgentBalance' 
      },


      ],
      agentPayables: [],//end table total daily payables
      
      //table total daily transaction
      headers_daily: [
      {
        text: 'Branch',
        value: 'agentCode'
      },
      { text: 'Service Charge', value: 'serviceCharge' },
      { text: 'Count', value: 'count' },
      { text: 'Total Payment', value: 'totalPayment' },

      ],
      dailyTransaction: [
     
      ],//end table total daily transaction
        //chart data
        dataChart: {},
        arrChart: [],
        chartOptions: {
          chart: {
            dropShadow: {
              enabled: true,
              color: '#111',
              top: -1,
              left: 3,
              blur: 3,
              opacity: 0.2
            }
          },
          stroke: {
            width: 0,
          },
          labels: ["Verification", "Approved", "Completed"],
          dataLabels: {
            dropShadow: {
              blur: 3,
              opacity: 0.8
            }
          },
          fill: {
            type: 'gradient',
            opacity: 1,
            pattern: {
              enabled: true,
              style: ['verticalLines', 'squares', 'horizontalLines', 'circles', 'slantedLines'],
            },
          },
          states: {
            hover: {
              enabled: false
            }
          },
          theme: {
            palette: 'palette2'
          },
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 200
              },
              legend: {
                position: 'bottom'
              }
            }
          }]
        }
      }),
      methods:{
        service_charges(){
          axios.get('./api/serviceCharges').then(response => this.serviceCharges = response.data);
        },
        
        exchange_rate(){
          axios.get('./api/exchangeRate').then(response => this.exchangeRate = response.data);
        },
        transaction_logs(){
          axios.get('./api/transactionLogs').then(response => this.transactionLogs = response.data);
        },

        total_daily_transaction(){
          axios.get('./api/dailyTransaction').then(response => this.dailyTransaction = response.data);
        },

        agent_payable(){
          axios.get('./api/agentPayable/1').then(response => this.agentPayables = response.data);
        },
        transaction_chart(){
          axios.get('./api/transactionChart')
            .then(response => {
              this.dataChart = response.data[0];
              this.arrChart = Object.values(this.dataChart);
            }); 
        },
        
        routemenu(menuname){
          this.$router.push({name: menuname})
        } 
      },

      created(){
        this.transaction_chart();
        this.service_charges();
        this.exchange_rate();
        this.transaction_logs();
        this.total_daily_transaction();
        this.agent_payable();
      },

      computed:{
        total_count(){
          return this.dailyTransaction.reduce(function(sum, transaction){
              return sum + transaction.count
          },0)
        },
        total_payment(){
          return this.dailyTransaction.reduce(function(sum, transaction){
              return sum + Number(transaction.totalPayment)
          },0)
            }
      }
    }
  </script>