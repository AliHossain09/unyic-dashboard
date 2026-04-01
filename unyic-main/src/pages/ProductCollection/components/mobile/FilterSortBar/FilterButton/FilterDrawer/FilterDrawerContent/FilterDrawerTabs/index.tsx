import type {
  FilterKey,
  Filters,
} from "../../../../../../../../../types/productsFilter";
import { useSearchParams } from "react-router";
import FilterTab from "./FilterTab";

interface FilterDrawerTabsProps {
  activeTab: FilterKey;
  setActiveTab: (key: FilterKey) => void;
  filters: Filters;
}

const FilterDrawerTabs = ({
  activeTab,
  setActiveTab,
  filters,
}: FilterDrawerTabsProps) => {
  const [searchParam] = useSearchParams();
  const { brand, color, size, price, discount } = filters || {};

  return (
    <ul className="divide-y divide-neutral-100 bg-neutral-200 overflow-y-auto">
      {brand && (
        <FilterTab
          label="brand"
          isActive={activeTab === "brand"}
          onClick={() => setActiveTab("brand")}
          count={searchParam.getAll("brand").length}
        />
      )}

      {color && (
        <FilterTab
          label="color"
          isActive={activeTab === "color"}
          onClick={() => setActiveTab("color")}
          count={searchParam.getAll("color").length}
        />
      )}

      {size && (
        <FilterTab
          label="size"
          isActive={activeTab === "size"}
          onClick={() => setActiveTab("size")}
          count={searchParam.getAll("size").length}
        />
      )}

      {price && (
        <FilterTab
          label="price"
          isActive={activeTab === "price"}
          onClick={() => setActiveTab("price")}
          showActiveDot={searchParam.get("price") !== null}
        />
      )}

      {discount && (
        <FilterTab
          label="discount"
          isActive={activeTab === "discount"}
          onClick={() => setActiveTab("discount")}
          showActiveDot={discount.active_discount_id !== null}
        />
      )}
    </ul>
  );
};

export default FilterDrawerTabs;
