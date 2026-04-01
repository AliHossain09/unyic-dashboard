import type { Id } from ".";
import type { FILTER_KEYS } from "../constants/filterKeys";
import type { SORT_OPTIONS } from "../constants/sortOptions";

export type SortOption = (typeof SORT_OPTIONS)[number];

export interface FilterOptionType {
  label: string;
  count: number;
}

export interface DiscountFilterOption extends FilterOptionType {
  id: Id;
}

export interface DiscountFilterType {
  options: DiscountFilterOption[];
  active_discount_id: null | number;
}

export interface PriceFilterType {
  min: number;
  max: number;
}

export type FilterKey = (typeof FILTER_KEYS)[number];

export interface Filters {
  brand: FilterOptionType[];
  color: FilterOptionType[];
  size: FilterOptionType[];
  price: PriceFilterType;
  discount: DiscountFilterType;
}
