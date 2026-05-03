import { FiHeart } from "react-icons/fi";
import { Link } from "react-router";
import { useWishlist } from "../../../../../contexts/wishlist/useWishlist";
import IconBadge from "../IconBadge";

const WishlistLink = () => {
  const { wishlist } = useWishlist();

  return (
    <Link to={"/wishlist"}>
      <IconBadge Icon={FiHeart} count={wishlist.length} />
    </Link>
  );
};

export default WishlistLink;
