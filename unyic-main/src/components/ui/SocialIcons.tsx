import { BsInstagram } from "react-icons/bs";
import {
  FaFacebookF,
  FaPinterestP,
  FaTwitter,
  FaYoutube,
} from "react-icons/fa";

const SocialIcons = () => {
  return (
    <>
      <a href="https://instagram.com">
        <BsInstagram />
      </a>
      <a href="https://twitter.com">
        <FaTwitter />
      </a>
      <a href="https://facebook.com">
        <FaFacebookF />
      </a>
      <a href="https://youtube.com">
        <FaYoutube />
      </a>
      <a href="https://pinterest.com">
        <FaPinterestP />
      </a>
    </>
  );
};

export default SocialIcons;
