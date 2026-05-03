import AccordionItem from "../../../../../components/ui/AccordionItem";
import type { Filters } from "../../../../../types/productsFilter";
import DiscountFilter from "../shared/DiscountFilter";
import GroupFilter from "../shared/GroupFilter";
import PriceFilter from "../shared/PriceFilter";
import FilterHeader from "./FilterHeader";

interface ProductFiltersDesktopProps {
  filters: Filters;
}

const ProductFiltersDesktop = ({ filters }: ProductFiltersDesktopProps) => {
  const { brand, color, size, price, discount } = filters || {};

  return (
    <>
      <FilterHeader />

      <div className="max-h-[calc(100dvh-226px)] pe-2 border-t overflow-y-auto overflow-x-hidden">
        {discount && (
          <AccordionItem title={"Discount"}>
            <div className="ps-3 py-4">
              <DiscountFilter discountFilter={discount} />
            </div>
          </AccordionItem>
        )}

        {price && (
          <AccordionItem title="Price">
            <div className="py-4 ps-3 space-y-4">
              <PriceFilter priceFilter={price} />{" "}
            </div>
          </AccordionItem>
        )}

        {brand && (
          <AccordionItem title={"Brand"}>
            <div className="ps-3 py-4">
              <GroupFilter paramKey="brand" options={brand} />
            </div>
          </AccordionItem>
        )}

        {color && (
          <AccordionItem title={"Color"}>
            <div className="ps-3 py-4">
              <GroupFilter paramKey="color" options={color} />
            </div>
          </AccordionItem>
        )}

        {size && (
          <AccordionItem title={"Size"}>
            <div className="ps-3 py-4">
              <GroupFilter paramKey="size" options={size} />
            </div>
          </AccordionItem>
        )}
      </div>
    </>
  );
};

export default ProductFiltersDesktop;
