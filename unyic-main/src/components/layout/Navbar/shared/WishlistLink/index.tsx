import { FiHeart } from "react-icons/fi";
import { Link } from "react-router";
import { useWishlist } from "../../../../../contexts/wishlist/useWishlist";
import useModalById from "../../../../../hooks/useModalById";
import useUser from "../../../../../hooks/useUser";
import IconBadge from "../IconBadge";

const WishlistLink = () => {
  const { openModalWithData } = useModalById("authModal");
  const { user } = useUser();
  const { wishlist } = useWishlist();

  if (!user) {
    return (
      <button
        onClick={() => openModalWithData({ activeTab: "login" })}
        className="cursor-pointer"
        aria-label="Wishlist button to open login modal"
      >
        <IconBadge Icon={FiHeart} />
      </button>
    );
  }

  return (
    <Link to={"/wishlist"}>
      <IconBadge Icon={FiHeart} count={wishlist.length} />
    </Link>
  );
};

export default WishlistLink;
