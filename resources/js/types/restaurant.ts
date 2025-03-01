import type { Product } from './product'
import type { Pagination } from '@/global'

export interface Restaurant {
  id?: string
  name: string
  description?: string
  address?: string
  phone?: string
  createdAt?: string
  updatedAt?: string

  // relationships
  owner?: any
  products?: Array<Product>
}

export interface PaginationRestaurants extends Pagination {
  data: Array<Restaurant>
}
