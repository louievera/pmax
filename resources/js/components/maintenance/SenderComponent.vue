<template>
	<v-content>
		<v-container grid-list-md text-center>
			<v-toolbar flat color="white">
				<v-toolbar-title>Sender</v-toolbar-title>
				<v-divider
				class="mx-2"
				inset
				vertical
				></v-divider>
				<v-spacer></v-spacer>
				<v-dialog v-model="dialog" max-width="500px">
					<template v-slot:activator="{ on }">
						<v-text-field
						v-model="search"
						append-icon="search"
						label="Search"
						single-line
						hide-details
						></v-text-field>
						<v-btn color="primary" dark class="mb-2" v-on="on">New Item</v-btn>
					</template>
					<v-card>
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>

						<v-card-text>
							<v-container grid-list-md>
								<v-layout wrap>
									<v-flex xs12 sm6 md4>
										<v-text-field v-model="editedItem.name" label="Dessert name"></v-text-field>
									</v-flex>
									<v-flex xs12 sm6 md4>
										<v-text-field v-model="editedItem.calories" label="Calories"></v-text-field>
									</v-flex>
									<v-flex xs12 sm6 md4>
										<v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>
									</v-flex>
									<v-flex xs12 sm6 md4>
										<v-text-field v-model="editedItem.carbs" label="Carbs (g)"></v-text-field>
									</v-flex>
									<v-flex xs12 sm6 md4>
										<v-text-field v-model="editedItem.protein" label="Protein (g)"></v-text-field>
									</v-flex>
								</v-layout>
							</v-container>
						</v-card-text>

						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
							<v-btn color="blue darken-1" flat @click="save">Save</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</v-toolbar>

			
			<v-data-table
			:headers="headers"
			:items="list"
			class="elevation-1"
			:search="search"
			>
			<template v-slot:items="props">
				<td class="justify-center layout px-0">
					<v-icon
					small
					class="mr-2"
					@click="editItem(props.item)">
						edit
					</v-icon>
					<v-icon
					small
					@click="deleteItem(props.item)">
						delete
					</v-icon>
				</td>
				<td class="text-xs-left">{{ props.item.sender.fname }}</td>
				<td class="text-xs-left">{{ props.item.sender.mname }}</td>
				<td class="text-xs-left">{{ props.item.sender.lname }}</td>
				<td class="text-xs-left">{{ props.item.sender.suffix }}</td>
				<td class="text-xs-left">{{ props.item.sender.bday }}</td>
				<td class="text-xs-left">{{ props.item.sender.place_of_birth }}</td>
				<td class="text-xs-left">{{ props.item.sender.contact_no }}</td>
				<td class="text-xs-left">{{ props.item.sender.citizenship }}</td>
				<td class="text-xs-left">{{ props.item.sender.residency }}</td>
				<td class="text-xs-left">{{ props.item.sender.country }}</td>
				<td class="text-xs-left">{{ props.item.sender.address }}</td>
				<td class="text-xs-left">{{ props.item.sender.address_ph }}</td>
				<td class="text-xs-left">{{ props.item.sender.suburub }}</td>
				<td class="text-xs-left">{{ props.item.sender.state }}</td>
				<td class="text-xs-left">{{ props.item.sender.post_code }}</td>
				<td class="text-xs-left">{{ props.item.sender.occupation }}</td>
				<td class="text-xs-left">{{ props.item.sender.source_of_inc }}</td>
				<td class="text-xs-left">{{ props.item.sender.status }}</td>
				<td class="text-xs-left">{{ props.item.sender.email }}</td>

				
	</template>

	<template v-slot:no-data>
		<v-btn color="primary" @click="initialize">Reset</v-btn>
	</template>
</v-data-table>
</v-container>
</v-content>
</template>

<script>
	export default {
		data: () => ({
			search: '',
			dialog: false,
			headers: [
			{ text: 'Edit'},

			{ text: 'First Name', sortable: false, value: 'fname'},
			{ text: 'Middle Name', sortable: false, value: 'mname'},
			{ text: 'Last Name', sortable: false, value: 'lname'},
			{ text: 'Suffix', sortable: false, value: 'suffix'},
			{ text: 'Birth Day', sortable: false, value: 'bday'},
			{ text: 'Place of Birth', sortable: false, value: 'place_of_birth'},
			{ text: 'Contact Number', value: 'contact_no' },
			{ text: 'Citizenship', value: 'citizenship' },			
			{ text: 'Residency', value: 'residency' },
			{ text: 'Country', value: 'country' },
			{ text: 'Address', value: 'address' },
			{ text: 'Address in PH', value: 'naddress_ph', },
			{ text: 'Suburb', value: 'suburb', },
			{ text: 'State', value: 'state', },
			{ text: 'Post Code', value: 'post_code', },
			{ text: 'Occupation', value: 'occupation', },
			{ text: 'Source of Income', value: 'source_of_inc', },
			{ text: 'Status', value: 'status', },
			{ text: 'Email', value: 'email', },

			],
			
			list:[],
			editedIndex: -1,
			editedItem: {
				name: '',
				calories: 0,
				fat: 0,
				carbs: 0,
				protein: 0
			},
			defaultItem: {
				name: '',
				calories: 0,
				fat: 0,
				carbs: 0,
				protein: 0
			}
		}),

		computed: {
			formTitle () {
				return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
			}
		},

		watch: {
			dialog (val) {
				val || this.close()
			}
		},

		created () {
			this.initialize()
		},

		methods: {
			initialize () {
				axios('./api/senderList').then(response => this.list = response.data);
			},

			editItem (item) {
				this.editedIndex = this.desserts.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialog = true
			},

			deleteItem (item) {
				const index = this.desserts.indexOf(item)
				confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
			},

			close () {
				this.dialog = false
				setTimeout(() => {
					this.editedItem = Object.assign({}, this.defaultItem)
					this.editedIndex = -1
				}, 300)
			},

			save () {
				if (this.editedIndex > -1) {
					Object.assign(this.desserts[this.editedIndex], this.editedItem)
				} else {
					this.desserts.push(this.editedItem)
				}
				this.close()
			}
		}
	}
</script>