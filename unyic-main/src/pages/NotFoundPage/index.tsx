import Navbar from "../../components/layout/Navbar";
import Button from "../../components/ui/Button";

const NotFoundPage = () => {
  return (
    <>
      <Navbar />

      <div className="min-h-dvh grid place-items-center text-dark bg-light">
        <div className="ui-container my-12">
          <div className="space-y-4 text-center">
            <h2
              className="text-8xl font-semibold text-[#ede3e0]"
              style={{
                textShadow: `
                  1px 1px 0px #BB4125,
                  -1px -1px 0px #BB4125,
                  1px -1px 0px #BB4125,
                  -1px 1px 0px #BB4125
                `,
              }}
            >
              404
            </h2>
            <h3 className="text-2xl uppercase">Page Not Found</h3>
          </div>

          <p className="mt-6 mb-8 max-w-md mx-auto text-balance text-center text-sm sm:text-base text-dark-light">
            The page you're looking for seems to have wandered off — much like a
            craftsman travelling to distant villages in search of the rarest
            weave. Let us guide you back.
          </p>

          <Button href="/" className="w-48! mx-auto block">
            Go to homepage
          </Button>
        </div>
      </div>
    </>
  );
};

export default NotFoundPage;
