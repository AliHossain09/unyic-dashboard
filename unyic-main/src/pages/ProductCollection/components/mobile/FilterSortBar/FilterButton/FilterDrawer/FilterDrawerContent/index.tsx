import { useState } from "react";
import type {
  FilterKey,
  Filters,
} from "../../../../../../../../types/productsFilter";
import FilterDrawerTabs from "./FilterDrawerTabs";
import { FILTER_KEYS } from "../../../../../../../../constants/filterKeys";
import GroupFilter from "../../../../../shared/GroupFilter";
import DiscountFilter from "../../../../../shared/DiscountFilter";
import PriceFilter from "../../../../../shared/PriceFilter";

interface FilterDrawerContentProps {
  filters: Filters;
}

const FilterDrawerContent = ({ filters }: FilterDrawerContentProps) => {
  const { brand, color, size, price, discount } = filters || {};

  // Tracks which filter group is currently visible
  const [activeTab, setActiveTab] = useState<FilterKey>(FILTER_KEYS[0]);

  return (
    <div className="h-[calc(100vh-64px-68px)] grid grid-cols-[1fr_2.3fr]">
      {/* Left-side tabs */}
      <FilterDrawerTabs
        activeTab={activeTab}
        setActiveTab={setActiveTab}
        filters={filters}
      />

      {/* Filter Options Content */}
      <div className="p-4 overflow-y-auto">
        {brand && activeTab === "brand" && (
          <GroupFilter paramKey="brand" options={brand} />
        )}

        {color && activeTab === "color" && (
          <GroupFilter paramKey="color" options={color} />
        )}

        {size && activeTab === "size" && (
          <GroupFilter paramKey="size" options={size} />
        )}

        {price && activeTab === "price" && <PriceFilter priceFilter={price} />}

        {/* Range filter: discount */}
        {discount && activeTab === "discount" && (
          <DiscountFilter discountFilter={discount} />
        )}
      </div>
    </div>
  );
};

export default FilterDrawerContent;
