<template>
	<v-content>
		<v-container grid-list-md text-center>
	   <v-toolbar flat color="white">
      <v-toolbar-title>Direct User Approval</v-toolbar-title>
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
      :items="regUsers"
      class="elevation-1"
      :search="search"
    >
      <template v-slot:items="props">
        <!-- <td>{{ props.item.name }}</td> -->
        <td class="text-xs-left" v-if="props.item.validated_by == null"><v-btn class="primary">Validate</v-btn></td>
        <td class="text-xs-center" v-else><b>Validated</b></td>        
        <td class="text-xs-left">{{ props.item.email }}</td>
        <td class="text-xs-left">{{ props.item.fname}},{{props.item.lname}}</td>
        <td class="text-xs-left">{{ props.item.contact_no }}</td>
        <td class="text-xs-left">{{ props.item.address }}</td>
        <td class="text-xs-left">{{ props.item.address_ph }}</td>
        <td class="text-xs-left">{{ props.item.bday }}</td>
        <td class="text-xs-left">{{ props.item.place_of_birth }}</td>
        <td class="text-xs-left">{{ props.item.occupation }}</td>
        <td class="text-xs-left">{{ props.item.residency }}</td>
        <td class="text-xs-left">{{ props.item.source_of_inc }}</td>
        <td class="text-xs-left">{{ props.item.created_at }}</td>

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
        regUsers: [],
      dialog: false,
      headers: [
        { text: 'Validate', align: 'left', sortable: false, value: 'name'},
        { text: 'Email', value: 'calories' },
        { text: 'Full Name', value: 'fat' },
        { text: 'Contact Number', value: 'carbs' },
        { text: 'Address', value: 'protein' },
        { text: 'Permanent Address', value: 'name', sortable: false },
        { text: 'Birthday', value: 'name', sortable: false },
        { text: 'Place of Birth', value: 'name', sortable: false },
        { text: 'Occupation', value: 'name', sortable: false },
        { text: 'Residency', value: 'name', sortable: false },
        { text: 'Source of Income', value: 'name', sortable: false },
        { text: 'Signature', value: 'name', sortable: false },
        { text: 'Date Registered', value: 'name', sortable: false }
      ],
      desserts: [],
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
        axios.get('./api/regUsers').then(response => this.regUsers = response.data);

      },

      editItem (item) {
        this.editedIndex = this.regUsers.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.regUsers.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.regUsers.splice(index, 1)
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
          Object.assign(this.regUsers[this.editedIndex], this.editedItem)
        } else {
          this.regUsers.push(this.editedItem)
        }
        this.close()
      }
    }
  }
</script>