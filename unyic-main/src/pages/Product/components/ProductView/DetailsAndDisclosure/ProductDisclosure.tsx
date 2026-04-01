import AccordionItem from "../../../../../components/ui/AccordionItem";
import type { ProductDisclosureType } from "../../../../../types";
import InfoRow from "./InfoRow";

interface ProductDisclosureProps {
  disclosure: ProductDisclosureType;
}

const ProductDisclosure = ({ disclosure }: ProductDisclosureProps) => {
  const { mrp, netQuantity, countryOfOrigin, manufactureDate } = disclosure;

  return (
    <AccordionItem title="Product Disclosure">
      <div className="p-4 text-dark text-sm space-y-4">
        <InfoRow label="MRP" value={`₹ ${mrp}`} />
        <InfoRow label="Net Quantity" value={netQuantity} />
        <InfoRow label="Country of Origin" value={countryOfOrigin} />
        <InfoRow label="Manufacture Date" value={manufactureDate} />
      </div>
    </AccordionItem>
  );
};

export default ProductDisclosure;
