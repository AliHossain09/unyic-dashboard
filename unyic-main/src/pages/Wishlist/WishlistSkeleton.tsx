import ProductCardSkeleton from "../../components/cards/ProductCard/ProductCardSkeleton";

const WishlistSkeleton = () => {
  return (
    <main className="ui-container my-10">
      <div className="mb-6 space-y-2">
        <h3 className="h-8 w-24 mx-auto rounded-full bg-gray-200" />
        <p className="h-4 w-16 mx-auto rounded-full bg-gray-200" />
      </div>

      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-4 gap-8">
        {[...Array(5)].map((_, index) => (
          <ProductCardSkeleton key={index} />
        ))}
      </div>
    </main>
  );
};

export default WishlistSkeleton;
