<template>
	<v-content>
		<v-container grid-list-md text-center>
			<v-card>
				<v-card-title
				class="headline yellow"
				primary-title
				>
				Bank to Bank
			</v-card-title>
			<v-card-text>
				<v-layout  wrap>
					<v-flex xs12 s12 md3 lg3 xl3  >
						<v-select
						item-text="status"
						item-value="id"
						:items="transaction_status"
						v-model="selected_status"
						label="Select Status"
						return-object
						></v-select>
					</v-flex>
					<v-flex xs12 s12 md2 lg2 xl2  >
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
				<v-flex xs12 s12 md2 l2 xl2  >

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
			
			<v-flex xs12 s12 md3 lg3 xl3  >
				
				<v-btn color="primary" @click="search">SEARCH</v-btn>
			</v-flex>
		</v-layout>
		
		<v-data-table
		:headers="headers"
		:items="desserts"
		class="elevation-1"
		>
		<template v-slot:items="props">
		
			<td class="text-xs-right">{{ props.item.approved_at }}</td>
			<td class="text-xs-right">{{ props.item.u_fname }} {{ props.item.u_lname }}</td>
				<td class="text-xs-right">{{ props.item.tracking_no }}</td>
			<td class="text-xs-right">{{ props.item.s_fname }} {{ props.item.s_lname }}</td>
			<td class="text-xs-right">{{ props.item.total_payment }}</td>
			<td class="text-xs-right">{{ props.item.exchange_rate }}</td>
		</template>
	</v-data-table>
	
</v-card-text>
</v-card>
</v-container>
</v-content>
</template>
<script>
	export default {
		data: () => ({
			headers: [

			{ text: 'DATE', value: 'date', align:'center' },
			{ text: "TELLER'S NAME" , value: 't_name' , align:'center'},
			{ text: 'REFERRENCE NUMBER', value: 'r_num', align:'center' },
			{ text: "SENDER'S NAME", value: 's_name' , align:'center'},
			{ text: 'AUD AMOUNT', value: 'aud_amount' , align:'center'},
			{ text: 'RATE', value: 'rate' , align:'center'}
			],
			desserts: [],
			start_date: new Date().toISOString().substr(0, 10),
			end_date: new Date().toISOString().substr(0, 10),
			menu: false,
			modal: false,
			menu2: false,
			transaction_status:[],
			selected_status:[],
		}),
		created(){
			this.initialize()
		},
		methods:{
			initialize () { 

				axios.get('./api/transactionstatus').then(response => {
					this.transaction_status = response.data
				});
			},
			search(){

				
				axios.get('./api/transaction/bank_to_bank/search',
					{params:
						{
							status:this.selected_status.id,
							from:this.start_date,
							to:this.end_date,
						} 
					})
				.then(response => {
					
					console.log(response.data)
					this.desserts = response.data
				});

			}
		}
	}
</script>

