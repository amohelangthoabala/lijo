import { helpers, maxLength, required } from '@vuelidate/validators'
import type { TableHeader } from './../j-components/types'
import type { Restaurant } from '@/types/restaurant'

type FormType = 'create' | 'edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useRestaurantStore = defineStore('restaurant', () => {
  // Processing state
  let processing = $ref<boolean>(false)

  // Data form state
  const form = $ref<Restaurant>({
    id: '',
    name: '',
    description: '',
    address: '',
    phone: '',
    owner: null,
    products: [],
  })

  // Form state
  const formState = $ref<FormState>({
    type: 'create',
    show: false,
    title: 'New Restaurant',
    description: 'Create a new restaurant',
  })

  // Table headers
  const headers = $ref<TableHeader[]>([
    {
      text: 'Name',
      value: 'name',
      class: 'min-w-[12rem]',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
    },
    {
      text: 'Address',
      value: 'address',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
    },
    {
      text: 'Phone',
      value: 'phone',
    },
    {
      text: 'Owner',
      value: 'owner',
    },
    {
      text: 'Created',
      value: 'created_at',
      sortable: true,
    },
    {
      text: '',
      value: 'actions',
      class: '!relative !pl-3 !pr-4 !sm:pr-6',
    },
  ])

  // Validation rules
  const rules = {
    id: {},
    name: {
      required: helpers.withMessage('Restaurant name is required', required),
      $autoDirty: true,
    },
    description: {
      required: helpers.withMessage('Restaurant description is required', required),
      minLengthValue: maxLength(100),
      $autoDirty: true,
    },
    address: {
      required: helpers.withMessage('Address is required', required),
      $autoDirty: true,
    },
    phone: {
      required: helpers.withMessage('Phone number is required', required),
      $autoDirty: true,
    },
  }

  const $externalResults = ref({})
  const $v = useVuelidate(rules as any, form, { $externalResults })

  // Submit form
  async function submitForm() {
    if (!await $v.value.$validate())
      return

    if (formState.type === 'create')
      createRestaurant()
    else
      updateRestaurant(form.id as string)
  }

  // Reload restaurants
  function reload() {
    Inertia.reload({
      only: ['restaurants'],
      onBefore: () => { processing = true },
      onFinish: () => { processing = false },
      onSuccess: () => {
        useNotificationStore().add({
          id: parseInt(_.uniqueId()),
          title: 'Restaurants successfully reloaded',
        })
      },
    })
  }

  // Get restaurants
  function getRestaurants(requestData: any) {
    Inertia.get(route('admin.restaurants.index'),
      {
        ...route().params,
        ...requestData,
      },
      {
        preserveState: true,
        replace: true,
        only: ['restaurants'],
        onBefore: () => { processing = true },
        onFinish: () => { processing = false },
      },
    )
  }

  // Create restaurant
  async function createRestaurant() {
    Inertia.post(route('admin.restaurants.store'), form as any, {
      onBefore: () => { processing = true },
      onFinish: () => { processing = false },
      onError: (error) => { $externalResults.value = error },
      onSuccess: () => { resetForm() },
    })
  }

  // Update restaurant
  async function updateRestaurant(id: string) {
    Inertia.put(route('admin.restaurants.update', id), form as any, {
      onBefore: () => { processing = true },
      onFinish: () => { processing = false },
      onError: (error) => { $externalResults.value = error },
      onSuccess: () => {
        resetForm()
        resetFormState()
      },
    })
  }

  // Delete restaurant
  function deleteRestaurant(id: string) {
    Inertia.delete(route('admin.restaurants.destroy', id), {
      onBefore: () => { processing = true },
      onFinish: () => { processing = false },
    })
  }

  // Delete multiple restaurants
  function deleteRestaurants(ids: string[]) {
    Inertia.delete(route('admin.restaurants.destroy-multiple'), {
      data: { ids },
      onBefore: () => { processing = true },
      onFinish: () => { processing = false },
    })
  }

  // Restore restaurant
  function restoreRestaurant(id: string) {
    Inertia.put(route('admin.restaurants.restore', id), {}, {
      onBefore: () => { processing = true },
      onFinish: () => { processing = false },
    })
  }

  // Restore multiple restaurants
  function restoreRestaurants(ids: string[]) {
    Inertia.put(route('admin.restaurants.restore-multiple'), { ids }, {
      data: { ids },
      onBefore: () => { processing = true },
      onFinish: () => { processing = false },
    })
  }

  // Reset form
  function resetForm() {
    form.id = ''
    form.name = ''
    form.description = ''
    form.address = ''
    form.phone = ''
    form.owner = null
    form.products = []

    $v.value.$reset()
  }

  // Reset form state
  function resetFormState() {
    formState.type = 'create'
    formState.show = false
    formState.title = 'New Restaurant'
    formState.description = 'Create a new restaurant'
  }

  return $$({
    processing,
    headers,
    $v,
    form,
    formState,

    reload,
    getRestaurants,
    submitForm,
    resetForm,
    deleteRestaurant,
    deleteRestaurants,
    restoreRestaurant,
    restoreRestaurants,
    resetFormState,
  })
})

// Hot module replacement
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useRestaurantStore, import.meta.hot))
