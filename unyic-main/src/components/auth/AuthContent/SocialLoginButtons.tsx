import { FaFacebookF } from "react-icons/fa";
import { FcGoogle } from "react-icons/fc";

const SocialLoginButtons = () => {
  return (
    <>
      {/* Divider */}
      <div className="my-8 relative">
        <hr />
        <p className="w-max px-2 absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-light">
          <span className="text-dark">Or continue with</span>
        </p>
      </div>

      {/* Google and Facebook buttons */}
      <div className="flex items-center justify-center gap-4">
        <button
          className="w-28 py-2 border border-gray-300 rounded hover:shadow-md duration-300 flex items-center justify-center space-x-2"
          onClick={() => console.log("Google Login")}
        >
          <FaFacebookF className="text-lg text-blue-600" />
          <span className="text-dark">Facebook</span>
        </button>

        <button
          className="w-28 py-2 border border-gray-300 rounded hover:shadow-md duration-300 flex items-center justify-center space-x-2"
          onClick={() => console.log("Facebook Login")}
        >
          <FcGoogle className="text-lg" />
          <span className="text-dark">Google</span>
        </button>
      </div>
    </>
  );
};

export default SocialLoginButtons;