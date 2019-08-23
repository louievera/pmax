<template>
	<v-content>
		<v-container grid-list-md text-center>
			<v-card flat tile>
				<v-card-title  class="yellow">
					<div class="headline">Certificate</div>
				</v-card-title>
				<v-card-text>
					<v-layout wrap>
						<v-flex xs12 s12 md3 lg3 xl3  >
							<v-select
							item-text="business_name"
							item-value="id"
							:items="agent"
							v-model="selected_agent"
							label="Select Agent"
							return-object
							></v-select>
						</v-flex>
						<v-flex xs12 s12 md3 lg3 xl3  >
							<v-text-field
							label="Sender Name"
							placeholder="e.g. Reyes"
							v-model="keyword"
							></v-text-field>
						</v-flex>
						<v-flex xs12 s12 md3 lg3 xl3  >
							<v-btn color="info" @click="search">
								<v-icon>search</v-icon>
								Search
							</v-btn>
						</v-flex>
					</v-layout>
					<br>
					<v-data-table
					:headers="headers"
					:items="desserts"
					class="elevation-1"
					>
					<template v-slot:items="props">
						<td class="text-xs-center">{{ props.item.fname }} {{ props.item.mname }} {{ props.item.lname }}</td>
						<td class="text-xs-center">
							
							<div v-if="props.item.beneficiary.length !== 0">
								<v-autocomplete label="Select" 
								v-bind:items="props.item.beneficiary" 
								item-text="name"
								item-value="id"
								:menu-props="{maxHeight:'auto'}"
								lenth = 10px
								>
								<template slot="selection" slot-scope="data">
									{{ data.item.fname }}, {{ data.item.lname }}
								</template>
								<template slot="item" slot-scope="data">
									{{ data.item.fname }}, {{ data.item.lname }}
								</template>
							</v-autocomplete>
						</div>
						<div v-else>
							NO BENEFICIARIES
						</div>


					</td>
					<td class="text-xs-center">
						<div v-if="props.item.beneficiary.length !== 0">
							<v-btn color="info">
								Create Certificate
							</v-btn>
						</div>

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
		data: () => ({
			headers: [
			{ text: 'SENDER FULL NAME', value: 'fname',	sortable: false,align:'center' },
			{ text: 'BENEFICIARIES', value: 'beneficiaries',	sortable: false, align:'center'},
			{ text: 'ACTION', value: 'action',	sortable: false, align:'center'},
			],
			desserts: [],
			agent:[],
			keyword:'',
			selected_agent:{},
			e11:[]
		}),
		created(){
			this.initialize()
		},
		methods:{
			initialize () { 

				axios.get('./api/agent').then(response => {
					this.agent = response.data

				});
				
			},
			search(){

				axios.get('./api/sender/search',
					{params:
						{
							agent:this.selected_agent.id,
							keyword:this.keyword
						} 
					})
				.then(response => {
					this.desserts = response.data
				});
				
			}
		}
	}
</script>


