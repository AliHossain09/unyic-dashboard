interface Props {
  children: React.ReactNode;
}

const ProductsWithFiltersContainer = ({ children }: Props) => {
  return (
    <div className="ui-container mb-12 lg:grid lg:grid-cols-[1fr_3fr] lg:gap-8">
      {children}
    </div>
  );
};

export default ProductsWithFiltersContainer;
