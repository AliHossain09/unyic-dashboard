import { ImSpinner3 } from "react-icons/im";

const LoadingOverlay = () => {
  return (
    <div className="fixed z-50 inset-0 bg-light/60 grid place-items-center">
      <ImSpinner3 size={36} className="animate-spin text-dark-light" />
    </div>
  );
};

export default LoadingOverlay;