<template>
	<v-content>
		<v-container grid-list-md text-center>
			<v-toolbar flat color="white">
				<v-toolbar-title>Service Center</v-toolbar-title>
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
						@click="editItem(props.item)"
					>
					edit
				</v-icon>
				<v-icon
					small
					@click="deleteItem(props.item)"
				>
				delete
			</v-icon>
		</td>
				<td class="text-xs-left">{{ props.item.service_center }}</td>
				<td class="text-xs-left">{{ props.item.center_desc }}</td>
				
				
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
			{ text: ''},
			{ text: 'Service Center', value: 'service_center' },
			{ text: 'Description', value: 'center_desc' },
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
				axios.get('./api/serviceCenter').then(response => this.list = response.data);	
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