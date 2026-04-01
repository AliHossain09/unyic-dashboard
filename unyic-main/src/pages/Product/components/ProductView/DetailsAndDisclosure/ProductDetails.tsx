import AccordionItem from "../../../../../components/ui/AccordionItem";
import type { ProductDetailsType } from "../../../../../types";
import InfoRow from "./InfoRow";

interface ProductDetailsProps {
  details: ProductDetailsType;
}

const ProductDetails = ({ details }: ProductDetailsProps) => {
  const {
    brand,
    description,
    category,
    collection,
    color,
    careInstructions,
    disclaimer,
  } = details;

  return (
    <AccordionItem title="Product Details" defaultOpen={true}>
      <div className="p-4 text-dark text-sm space-y-4">
        <InfoRow label="Brand" value={brand} />
        <InfoRow label="Description" value={description} />
        <InfoRow label="Category" value={category} />
        <InfoRow label="Collection" value={collection} />
        <InfoRow label="Color" value={color} />
        <InfoRow label="Care Instructions" value={careInstructions} />
        <InfoRow label="Disclaimer" value={disclaimer} />
      </div>
    </AccordionItem>
  );
};

export default ProductDetails;
