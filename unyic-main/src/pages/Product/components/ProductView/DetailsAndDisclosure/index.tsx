import type {
  ProductDetailsType,
  ProductDisclosureType,
} from "../../../../../types/product";
import ProductDetails from "./ProductDetails";
import ProductDisclosure from "./ProductDisclosure";

interface DetailsAndDisclosureProps {
  details: ProductDetailsType;
  disclosure: ProductDisclosureType;
}

const DetailsAndDisclosure = ({
  details,
  disclosure,
}: DetailsAndDisclosureProps) => {
  return (
    <div>
      <ProductDetails details={details} />
      <ProductDisclosure disclosure={disclosure} />
    </div>
  );
};

export default DetailsAndDisclosure;
