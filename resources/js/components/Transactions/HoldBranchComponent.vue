<template>
	<v-content>
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
<v-container grid-list-md text-center>
 <div class="text-xs-center">
  <v-dialog
  v-model="dialog"
  width="500"
  >
  <v-card>
    <v-card-title
    class="headline yellow"
    primary-title
    >
    Remarks
  </v-card-title>

  <v-card-text>
    <v-text-field
    v-model="remarks"
    label="Remarks"
    required
    ></v-text-field>
  </v-card-text>

  <v-divider></v-divider>

  <v-card-actions>
    <v-spacer></v-spacer>
    <v-btn
    color="warning"
    flat
    @click="dialog = false;update(id)"
    >
    OK
  </v-btn>
</v-card-actions>
</v-card>
</v-dialog>
</div>
<v-card>
  <v-card-title class="yellow">
 <div class="headline">HOLD BRANCH</div>
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
 >
 <template v-slot:items="props">
  <td>
    <v-icon outline color="indigo" v-if="props.item.agent_status == 0">lock</v-icon>
    <v-icon outline color="indigo" v-else>lock_open</v-icon>
  </td>
  <td>  
    <v-btn v-if="props.item.agent_status == 0"outline color="indigo" @click="hold_open_modal(props.item.id)">
      HOLD
    </v-btn>
    <v-btn v-else outline color="indigo" @click="unhold_open_modal(props.item.id)">
      UNHOLD
    </v-btn>

  </td>
  <td>{{ props.item.business_name }}</td>
  <td class="text-xs-left">{{ props.item.agent_code }}</td>
  <td class="text-xs-left">{{ props.item.owner }}</td>
  <td class="text-xs-left">
    <div v-if = "props.item.agent_status == 1">
      HOLD
    </div>
    <div v-else>
      ACTIVE
    </div>

  </td>
  <td class="text-xs-left">
   <div v-if="props.item.agent_status == 0">

   </div>
   <div v-else >
     {{ props.item.remarks }}
   </div>

 </td>
 <td class="text-xs-left">
  <div v-if="props.item.agent_status == 0">

  </div>
  <div v-else>
   {{ props.item.updated_at }}
 </div>

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
        loading:true,
        remarks:null,
        dialog:false,
        id:null,
        search: '',
        headers: [
        { text: '', value: ''},
        { text: 'UPDATE', value: ''},
        { text: 'BUSINESS NAME', value: 'business_name'},
        { text: 'BRANCH CODE', value: 'agent_code' },
        { text: 'OWNER', value: 'owner' },
        { text: 'STATUS', value: 'agent_status' },
        { text: 'REMARKS', value: 'remarks' },
        { text: 'DATE HOLD', value: 'updated_at' }
        ],
        desserts: []
      }
    },methods: {
      initialize () { 
        axios.get('./api/agent').then(response => {
          this.desserts = response.data
          this.loading= false
        });
        
      },
      hold_open_modal(id){
        this.dialog = true
        this.id = id

      },
      unhold_open_modal(id){
        axios.put('./api/agent/'+id+'/unhold', {
          id: id,
        }).then(response => {

          this.id = null;
          this.remarks = null;
          this.desserts = response.data
        });
      },
      update(id){
        axios.put('./api/agent/'+id+'/hold', {
          id: id,
          remarks: this.remarks
        }).then(response => {

          this.id = null;
          this.remarks = null;
          this.desserts = response.data
        });

      }
    },
    created () {
      this.initialize()
    }
  }
</script>