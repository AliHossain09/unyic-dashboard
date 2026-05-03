import { ImSpinner3 } from "react-icons/im";

const LoadingPage = () => {
  return (
    <div className="h-dvh grid place-items-center">
      <ImSpinner3 size={36} className="animate-spin text-dark-light" />
    </div>
  );
};

export default LoadingPage;
