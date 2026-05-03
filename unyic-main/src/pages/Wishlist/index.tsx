import ProductCard from "../../components/cards/ProductCard";
import { useWishlist } from "../../contexts/wishlist/useWishlist";
import EmptyWishlist from "./EmptyWishlist";
import WishlistSkeleton from "./WishlistSkeleton";

const Wishlist = () => {
  const { wishlist, isWishlistLoading } = useWishlist();

  if (isWishlistLoading) {
    return <WishlistSkeleton />;
  }

  if (wishlist.length === 0) {
    return <EmptyWishlist />;
  }

  return (
    <main className="ui-container my-10">
      <div className="mb-6 text-center">
        <h3 className="text-2xl font-semibold">Wishlist</h3>
        <p className="text-dark">{wishlist.length} items</p>
      </div>

      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-4 gap-8">
        {wishlist?.map((product) => (
          <ProductCard key={product.id} product={product} />
        ))}
      </div>
    </main>
  );
};

export default Wishlist;
