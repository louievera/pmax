<template>
	<v-content>
		<v-container grid-list-md text-center>
			<v-card flat tile>
				<v-card-title
				class="headline yellow"
				primary-title
				>
				New Remitter Count Per Month
			</v-card-title>
			<v-card-text>
				<v-data-table
				:headers="headers_count_per_month"
				:items="desserts_count_per_month"
				class="elevation-1"
				>
				<template v-slot:items="props">
					<td class="text-xs-center">{{ props.item.month }} {{ props.item.year }}</td>
					<td class="text-xs-center"> {{ props.item.count }}</td>


				</template>
			</v-data-table>
		</v-card-text>
	</v-card>
	<br>
	<br>
	<v-card flat tile>
		<v-card-title
		class="headline yellow"
		primary-title
		>
		Transaction Count/Volume Per Month
	</v-card-title>
	<v-card-text>
		<v-data-table
		:headers="headers_volume_per_month"
		:items="desserts_volume_per_month"
		class="elevation-1"
		>
		<template v-slot:items="props">
			<td class="text-xs-center">{{ props.item.month }} {{ props.item.year }}</td>
			<td class="text-xs-center">{{ props.item.receive_amount }}</td>
			<td class="text-xs-center">{{ props.item.send_amount_php }}</td>
			<td class="text-xs-center">{{ props.item.charge }}</td>
			<td class="text-xs-center"> AUD  {{ props.item.total_payment }}</td>
			<td class="text-xs-center">{{ props.item.avarage_rate }}</td>
			<td class="text-xs-center">{{ props.item.count }}</td>
		</template>
	</v-data-table>
</v-card-text>
</v-card >
<br>
<br>
<v-card flat tile>
	<v-card-title
	class="headline yellow"
	primary-title
	>
	Transaction Count/Volume Per Day
</v-card-title>
<v-card-text>
	<v-data-table
	:headers="headers_count_per_day"
	:items="desserts_count_per_day"
	class="elevation-1"
	>
	<template v-slot:items="props">
		<td class="text-xs-center">{{ props.item.created }}</td>
		<td class="text-xs-center">{{ props.item.send_total }}</td>
		<td class="text-xs-center">{{ props.item.remit_total }}</td>
		<td class="text-xs-center">{{ props.item.charge_total }}</td>
		<td class="text-xs-center">{{ props.item.payment_total }}</td>
		<td class="text-xs-center">{{ props.item.rate_ave }}</td>
		<td class="text-xs-center">{{ props.item.total }}</td>

		


	</template>
</v-data-table>
</v-card-text>
</v-card flat tile>
<br>
<br>
<v-card flat tile>
	<v-card-title
	class="headline yellow"
	primary-title
	>
	Transaction Count Per Branch
</v-card-title>
<v-card-text >
	<v-data-table
	:headers="headers_count_per_month"
	:items="desserts_count_per_month"
	class="elevation-1"
	>
	<template v-slot:items="props">
		<td class="text-xs-center">{{ props.item.name }}</td>
		<td class="text-xs-center">{{ props.item.calories }}</td>


	</template>
</v-data-table>
</v-card-text>
</v-card>
<br>
<br>
<v-card flat tile>
	<v-card-title
	class="headline yellow"
	primary-title
	>
	Transaction Count Per Service Mode
</v-card-title>
<v-card-text>
	<v-data-table
	:headers="headers_count_per_month"
	:items="desserts_volume_per_month"
	class="elevation-1"
	>
	<template v-slot:items="props">
		<td class="text-xs-center"> {{ props.item.month }}</td>
		<td class="text-xs-center">{{ props.item.total_payment }}</td>
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
				headers_count_per_month:[
				{
					text: 'Month / Year',
					align: 'center',
					sortable: false,
					value: 'name'
				},
				{ 	align: 'center', text: 'Count', value: 'count' ,sortable: false,},
				],
				desserts_count_per_month:[],
				headers_count_per_day:[
				{ 	align: 'center', text: 'Month/Year', value: 'month_year' ,sortable: false,},
				{ 	align: 'center', text: 'Send Amount (PHP)', value: 'send_amount' ,sortable: false,},
				{ 	align: 'center', text: 'Remit Amount (AUD)', value: 'remit_amount' ,sortable: false,},
				{ 	align: 'center', text: 'Remit Charge (AUD)', value: 'calories' ,sortable: false,},
				{ 	align: 'center', text: 'Total Payment (AUD)', value: 'calories' ,sortable: false,},
				{ 	align: 'center', text: 'Ave Rate', value: 'calories' ,sortable: false,},
				{ 	align: 'center', text: 'Count', value: 'calories' ,sortable: false,},
				],
				desserts_count_per_day:[],
				headers_volume_per_month: [
				{
					text: 'Month / Year',
					align: 'center',
					sortable: false,
					value: 'name'
				},
				{ 	align: 'center', text: 'Send Amount(PHP)', value: 'calories' ,sortable: false,},
				{ 	align: 'center', text: 'Remit Amount (AUD)', value: 'calories' ,sortable: false,},
				{ 	align: 'center', text: 'Remit Charge (AUD)', value: 'calories' ,sortable: false,},
				{ 	align: 'center', text: 'Total Payment (AUD)', value: 'calories' ,sortable: false,},
				{ 	align: 'center', text: 'Average Rage', value: 'count' ,sortable: false,},
				{ 	align: 'center', text: 'Count', value: 'count' ,sortable: false,},

				],
				desserts_volume_per_month: []
			}
		},
		created(){
			this.initialize()
		},methods:{
			initialize () { 

				axios.get('./api/transaction/counts').then(response => {
					this.desserts_volume_per_month = response.data.c_v_per_month
					this.desserts_count_per_month = response.data.r_per_month
					this.desserts_count_per_day = response.data.c_per_day
					
				});
				

			}
		}
	}
</script>

