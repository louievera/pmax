<template>
	<v-content>
		<v-container grid-list-md text-center>
			<v-card flat tile>
			<v-card-title
				class="headline yellow"
				primary-title
				>
				Create Transaction
			</v-card-title>
				<v-card-text>
					<v-flex>
				<v-stepper v-model="e1">
					<v-stepper-header>
						<v-stepper-step :complete="e1 > 1" step="1">Client</v-stepper-step>

						<v-divider></v-divider>

						<v-stepper-step :complete="e1 > 2" step="2">Confirm</v-stepper-step>

						<v-divider></v-divider>

						<v-stepper-step step="3">Receipt</v-stepper-step>
					</v-stepper-header>

					<v-stepper-items>
						<v-stepper-content step="1">
							<v-card
							class="mb-12"
							color="grey lighten-1"
							height="200px"
							></v-card>

							<v-btn
							color="primary"
							@click="e1 = 2"
							>
							Continue
						</v-btn>

						<v-btn text>Cancel</v-btn>
					</v-stepper-content>

					<v-stepper-content step="2">
						<v-card
						class="mb-12"
						color="grey lighten-1"
						height="200px"
						></v-card>

						<v-btn
						color="primary"
						@click="e1 = 3"
						>
						Continue
					</v-btn>

					<v-btn text>Cancel</v-btn>
				</v-stepper-content>

				<v-stepper-content step="3">
					<v-card
					class="mb-12"
					color="grey lighten-1"
					height="200px"
					></v-card>

					<v-btn
					color="primary"
					@click="e1 = 1"
					>
					Continue
				</v-btn>

				<v-btn text>Cancel</v-btn>
			</v-stepper-content>
		</v-stepper-items>
	</v-stepper>
</v-flex>
<br>

<v-flex xs12 sm12 md6 lg6>
	<v-btn
	color="primary"
	dark
	@click="dialog3 = !dialog3"
	>
	New Sender
	  <v-icon dark>add</v-icon>
</v-btn>
<v-text-field
label="Search Items"
prepend-inner-icon="search"
></v-text-field>
</v-flex>

				</v-card-text>
			</v-card>
		</v-container>

	</v-content>
</template>
<script>
	export default {
		data () {
			return {
				e1: 0,

			}
		},
	}
</script>